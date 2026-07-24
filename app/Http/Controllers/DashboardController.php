<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $shop = auth()->user()->shop;

        return view('dashboard', [
            'shop' => $shop,
            'productsCount' => $shop->products()->count(),
            'ordersCount' => $shop->orders()->count(),
            'pendingOrdersCount' => $shop->orders()->where('status', 'pending')->count(),
            'revenue' => $shop->orders()->where('status', 'delivered')->sum('total_amount'),
            'latestOrders' => $shop->orders()->with('items')->latest()->take(5)->get(),
        ]);
    }
}
