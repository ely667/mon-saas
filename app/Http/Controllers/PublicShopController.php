<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\View\View;

class PublicShopController extends Controller
{
    public function show(Shop $shop): View
    {
        abort_unless($shop->is_active && $shop->is_public, 404);

        return view('public.shop', [
            'shop' => $shop,
            'products' => $shop->products()
                ->where('is_active', true)
                ->latest()
                ->get(),
        ]);
    }
}
