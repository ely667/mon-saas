<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'shop_name' => ['required', 'string', 'max:255'],
            'whatsapp_phone' => ['required', 'string', 'max:30'],
            'commune' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        Shop::create([
            'user_id' => $user->id,
            'name' => $data['shop_name'],
            'slug' => $this->uniqueShopSlug($data['shop_name']),
            'whatsapp_phone' => $data['whatsapp_phone'],
            'city' => 'Abidjan',
            'commune' => $data['commune'] ?? null,
            'trial_ends_at' => now()->addDays(7),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Bienvenue sur VenteGo. Ta boutique est prete.');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function uniqueShopSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'boutique';
        $slug = $base;
        $count = 2;

        while (Shop::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$count}";
            $count++;
        }

        return $slug;
    }
}
