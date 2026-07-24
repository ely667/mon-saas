<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicOrderController extends Controller
{
    public function store(Request $request, Shop $shop): RedirectResponse
    {
        abort_unless($shop->is_active && $shop->is_public, 404);

        $data = $request->validate([
            'cart' => ['required', 'json'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_commune' => ['nullable', 'string', 'max:100'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = json_decode($data['cart'], true);

        if (!is_array($cart) || count($cart) === 0) {
            return back()->withErrors(['cart' => 'Panier vide.']);
        }

        $productIds = collect($cart)->pluck('id');
        $products = Product::where('shop_id', $shop->id)
            ->where('is_active', true)
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $orderItems = [];
        $totalAmount = 0;

        foreach ($cart as $entry) {
            $product = $products->get($entry['id']);
            if (!$product) {
                return back()->withErrors(['cart' => 'Produit introuvable.']);
            }

            $quantity = max(1, min(99, intval($entry['quantity'])));

            if ($product->stock < $quantity) {
                return back()->withErrors(['cart' => "Stock insuffisant pour {$product->name}. Disponible: {$product->stock}."]);
            }

            $lineTotal = $product->price * $quantity;
            $totalAmount += $lineTotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        $order = $shop->orders()->create([
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_commune' => $data['customer_commune'] ?? null,
            'customer_note' => $data['customer_note'] ?? null,
            'total_amount' => $totalAmount,
            'payment_method' => 'unknown',
        ]);

        $order->items()->createMany($orderItems);

        // Atomic stock decrement (race-condition safe)
        foreach ($orderItems as $item) {
            $affected = Product::where('id', $item['product_id'])
                ->where('stock', '>=', $item['quantity'])
                ->decrement('stock', $item['quantity']);
            if ($affected === 0) {
                // Another request took the last stock; rollback order
                $order->items()->forceDelete();
                $order->forceDelete();
                return back()->withErrors(['cart' => "Un produit n'est plus disponible en quantité suffisante."]);
            }
        }

        return redirect()
            ->route('shops.public.show', $shop)
            ->with('success', 'Commande envoyee. Le vendeur va te repondre sur WhatsApp.');
    }
}
