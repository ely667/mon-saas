<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = auth()->user()->shop->orders()
            ->with('items')
            ->latest()
            ->paginate(15);

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
        ]);
    }

    public function show(Order $order): View
    {
        $this->authorizeOrder($order);

        return view('orders.show', [
            'order' => $order->load('items'),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        $data = $request->validate([
            'status' => ['required', 'string', 'in:'.implode(',', array_keys(Order::STATUSES))],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Statut mis a jour.');
    }

    private function authorizeOrder(Order $order): void
    {
        abort_unless($order->shop_id === auth()->user()->shop->id, 403);
    }
}
