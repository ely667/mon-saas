<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Shop;

class ShopSettingsController extends Controller
{
    public function edit(): View
    {
        return view('shop.settings', [
            'shop' => auth()->user()->shop,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $shop = auth()->user()->shop;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'whatsapp_phone' => ['required', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:100'],
            'commune' => ['nullable', 'string', 'max:100'],
            'logo_path' => ['nullable', 'url', 'max:2048'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public');

        if ($data['name'] !== $shop->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $shop->id);
        }

        $shop->update($data);

        return back()->with('success', 'Boutique mise a jour.');
    }

    private function uniqueSlug(string $name, int $ignoreId): string
    {
        $base = Str::slug($name) ?: 'boutique';
        $slug = $base;
        $count = 2;

        while (Shop::where('slug', $slug)->whereKeyNot($ignoreId)->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }
}
