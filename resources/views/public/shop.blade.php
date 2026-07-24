<x-layouts.app :title="$shop->name">

    {{-- Dark theme overrides for this page only --}}
    <style>
        body { background: #0F0F17 !important; }
        .nav { display: none !important; }
        .footer { display: none !important; }
        main > .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        h1 { font-size: inherit !important; line-height: inherit !important; margin: 0 !important; }
        h2, h3 { margin: 0 !important; }
        main p { color: rgba(255,255,255,0.55) !important; line-height: 1.6; }
        main input, main textarea, main select { background: rgba(255,255,255,0.06) !important; border-color: rgba(255,255,255,0.08) !important; color: #fff !important; border-radius: 12px !important; }
        main input::placeholder, main textarea::placeholder { color: rgba(255,255,255,0.25) !important; }
        main input:focus, main textarea:focus, main select:focus { border-color: #6C5CE7 !important; box-shadow: 0 0 0 2px rgba(108,92,231,0.25) !important; outline: none !important; }
        main label { color: rgba(255,255,255,0.45) !important; font-size: 0.7rem !important; text-transform: uppercase !important; letter-spacing: 0.05em !important; }
        .alert-ok { background: rgba(16,185,129,0.12) !important; color: #6ee7b7 !important; border: 1px solid rgba(16,185,129,0.15) !important; border-radius: 12px !important; }
        .alert-error { background: rgba(239,68,68,0.12) !important; color: #fca5a5 !important; border: 1px solid rgba(239,68,68,0.15) !important; border-radius: 12px !important; }
    </style>

    @php
        $hash = crc32($shop->name);
        $hue = 250 + (abs($hash) % 30);
    @endphp

    <div x-data="cart()" x-init="init()" class="min-h-screen text-white" style="background:#0F0F17;">

        {{-- ============================================= --}}
        {{-- STICKY HEADER --}}
        {{-- ============================================= --}}
        <header class="fixed top-0 inset-x-0 z-50 border-b border-white/5" style="background:rgba(15,15,23,0.82); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px);">
            <div class="flex items-center justify-between px-4 h-13">
                <div class="flex items-center gap-2 min-w-0">
                    <svg class="w-4 h-4 text-white/30 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-sm font-semibold text-white truncate">{{ $shop->name }}</span>
                    @if($shop->verified ?? false)
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-[#3B82F6] flex items-center justify-center" title="Vérifié">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    @endif
                </div>
                <button @click="showCart = true" class="relative flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span x-show="items.length > 0" x-cloak class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-[#6C5CE7] text-white text-[9px] font-bold rounded-full flex items-center justify-center" x-text="items.length"></span>
                </button>
            </div>
        </header>

        {{-- ============================================= --}}
        {{-- HERO --}}
        {{-- ============================================= --}}
        <section class="pt-13" style="background:linear-gradient(180deg, #1a1035 0%, #12101f 60%, #0F0F17 100%);">
            <div class="flex flex-col items-center text-center px-4 sm:px-6 pt-8 sm:pt-12 pb-8 sm:pb-10">

                {{-- Logo rond --}}
                <div class="w-24 h-24 rounded-full flex items-center justify-center text-4xl font-extrabold text-white mb-5 shadow-lg" style="background:hsl({{ $hue }},60%,55%); box-shadow: 0 8px 32px hsl({{ $hue }},60%,55%,0.35);">
                    {{ strtoupper(mb_substr($shop->name, 0, 1)) }}
                </div>

                {{-- Localisation --}}
                @if($shop->commune || $shop->city)
                    <p class="flex items-center gap-1.5 text-white/40 text-xs mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $shop->commune }}{{ $shop->commune && $shop->city ? ', ' : '' }}{{ $shop->city }}
                    </p>
                @endif

                {{-- Titre --}}
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight mb-3 max-w-md">
                    {{ $shop->name }}
                </h1>

                {{-- Description --}}
                <p class="text-sm text-white/45 leading-relaxed max-w-sm mb-6">
                    {{ $shop->description ?: 'Découvrez les produits et commandez en quelques clics.' }}
                </p>

                {{-- Bandeau réassurance --}}
                <div class="inline-flex items-center gap-2.5 rounded-full px-5 py-2.5 text-xs font-medium text-white/60" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.06);">
                    <svg class="w-4 h-4 text-[#6C5CE7] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd"/></svg>
                    Réservation sécurisée par acompte — Wave, Orange, Moov
                </div>
            </div>
        </section>

        {{-- ============================================= --}}
        {{-- PRODUITS --}}
        {{-- ============================================= --}}
        <section class="px-4 py-8 max-w-lg mx-auto">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-white">Produits</h2>
                <span class="text-[11px] text-white/25 font-medium" x-show="items.length > 0" x-cloak x-text="items.length + ' article' + (items.length > 1 ? 's' : '')"></span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                @forelse ($products as $product)
                    <article class="rounded-2xl overflow-hidden flex flex-col" style="background:#1A1A2E;">
                        {{-- Image --}}
                        <div class="relative aspect-square overflow-hidden" style="background:#252540;">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white/8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                            @if($product->stock <= 0)
                                <span class="absolute top-2 left-2 text-[10px] font-semibold px-2 py-0.5 rounded-full" style="background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.2);">Rupture</span>
                            @endif
                        </div>

                        {{-- Body --}}
                        <div class="p-3 flex flex-col flex-1">
                            <h3 class="text-[13px] font-semibold text-white leading-snug" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $product->name }}</h3>

                            <p class="mt-1.5 text-sm font-bold" style="color:#A78BFA;">{{ number_format($product->price, 0, ',', ' ') }} <span class="text-[10px] font-medium" style="color:rgba(167,139,250,0.5);">FCFA</span></p>

                            <div class="mt-auto pt-3">
                                @if($product->stock > 0)
                                    <button
                                        x-on:click="addItem({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'stock' => $product->stock]) }})"
                                        class="w-full py-2.5 rounded-xl text-white text-sm font-semibold transition-colors duration-150 cursor-pointer" style="background:#6C5CE7;">
                                        Réserver
                                    </button>
                                @else
                                    <button disabled class="w-full py-2.5 rounded-xl text-sm font-semibold cursor-not-allowed" style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.2);">
                                        Indisponible
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <svg class="w-14 h-14 mx-auto mb-3 text-white/8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        <p class="text-white/25 text-sm font-medium">Boutique en préparation</p>
                        <p class="text-white/15 text-xs mt-1">Aucun produit pour le moment</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ============================================= --}}
        {{-- PAIEMENTS --}}
        {{-- ============================================= --}}
        <section class="py-10 text-center" style="background:#12121E;">
            <p class="text-[10px] uppercase tracking-[0.2em] font-semibold mb-6" style="color:rgba(255,255,255,0.2);">Paiements locaux acceptés</p>
            <div class="flex items-center justify-center gap-8">
                {{-- Wave --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.06);">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" fill="#0D99FF" opacity="0.2"/><text x="12" y="16" text-anchor="middle" fill="#0D99FF" font-size="10" font-weight="700">W</text></svg>
                    </div>
                    <span class="text-[11px] font-medium" style="color:rgba(255,255,255,0.3);">Wave</span>
                </div>
                {{-- Orange Money --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.06);">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8" fill="#FF6600" opacity="0.2"/><text x="12" y="16" text-anchor="middle" fill="#FF6600" font-size="10" font-weight="700">O</text></svg>
                    </div>
                    <span class="text-[11px] font-medium" style="color:rgba(255,255,255,0.3);">Orange</span>
                </div>
                {{-- Moov --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.06);">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8" fill="#FFD500" opacity="0.2"/><text x="12" y="16" text-anchor="middle" fill="#FFD500" font-size="10" font-weight="700">M</text></svg>
                    </div>
                    <span class="text-[11px] font-medium" style="color:rgba(255,255,255,0.3);">Moov</span>
                </div>
            </div>
        </section>

        {{-- ============================================= --}}
        {{-- FOOTER --}}
        {{-- ============================================= --}}
        <footer class="text-center py-6 text-[11px]" style="color:rgba(255,255,255,0.15); background:#0F0F17;">
            Propulsé par <span class="font-semibold" style="color:rgba(255,255,255,0.25);">VenteGo CI</span>
        </footer>

        {{-- ============================================= --}}
        {{-- PANIER (drawer) --}}
        {{-- ============================================= --}}
        <div x-show="showCart" x-cloak
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-end sm:items-center justify-center">

            <div class="absolute inset-0" style="background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" @click="showCart = false"></div>

            <div class="relative w-full sm:max-w-md sm:rounded-2xl rounded-t-2xl max-h-[88vh] flex flex-col" style="background:#1A1A2E; border:1px solid rgba(255,255,255,0.06);"
                 x-show="showCart"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full sm:translate-y-0 sm:scale-95 sm:opacity-0" x-transition:enter-end="translate-y-0 sm:scale-100 sm:opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 sm:scale-100 sm:opacity-100" x-transition:leave-end="translate-y-full sm:translate-y-0 sm:scale-95 sm:opacity-0">

                {{-- Header --}}
                <div class="sticky top-0 px-5 py-4 flex items-center justify-between rounded-t-2xl z-10 flex-shrink-0" style="background:#1A1A2E; border-bottom:1px solid rgba(255,255,255,0.06);">
                    <div>
                        <h3 class="font-bold text-sm text-white">Mon panier</h3>
                        <p class="text-[11px] mt-0.5" style="color:rgba(255,255,255,0.3);" x-text="items.length > 0 ? items.length + ' article' + (items.length > 1 ? 's' : '') : 'Vide'"></p>
                    </div>
                    <button @click="showCart = false" class="w-8 h-8 rounded-full flex items-center justify-center cursor-pointer transition-colors" style="background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.35);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="overflow-y-auto flex-1 px-5 py-4">
                    {{-- Empty --}}
                    <div x-show="items.length === 0" class="text-center py-10">
                        <svg class="w-12 h-12 mx-auto mb-3" style="color:rgba(255,255,255,0.08);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <p class="text-sm font-medium" style="color:rgba(255,255,255,0.3);">Ton panier est vide</p>
                    </div>

                    {{-- Items --}}
                    <div x-show="items.length > 0">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="flex items-center gap-3 py-3" style="border-bottom:1px solid rgba(255,255,255,0.04);">
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-white truncate" x-text="item.name"></p>
                                    <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.35);" x-text="item.priceFormatted + ' FCFA / u'"></p>
                                </div>
                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <button @click="decrement(index)" class="w-7 h-7 rounded-full flex items-center justify-center transition text-sm cursor-pointer" style="border:1px solid rgba(255,255,255,0.08); color:rgba(255,255,255,0.4);">−</button>
                                    <span class="w-6 text-center text-sm font-bold text-white" x-text="item.quantity"></span>
                                    <button @click="increment(index)" class="w-7 h-7 rounded-full flex items-center justify-center transition text-sm cursor-pointer" style="border:1px solid rgba(255,255,255,0.08); color:rgba(255,255,255,0.4);">+</button>
                                    <button @click="remove(index)" class="w-7 h-7 rounded-full flex items-center justify-center transition ml-0.5 text-sm cursor-pointer" style="color:rgba(248,113,113,0.5);">×</button>
                                </div>
                            </div>
                        </template>

                        <div class="flex items-center justify-between pt-4 mt-2" style="border-top:1px solid rgba(255,255,255,0.06);">
                            <span class="text-sm font-medium" style="color:rgba(255,255,255,0.4);">Total</span>
                            <span class="text-lg font-extrabold text-white" x-text="totalFormatted() + ' FCFA'"></span>
                        </div>
                    </div>

                    {{-- Formulaire --}}
                    <div x-show="items.length > 0" class="mt-5 pt-5" style="border-top:1px solid rgba(255,255,255,0.06);">
                        <h4 class="font-bold text-xs mb-4" style="color:rgba(255,255,255,0.5);">Tes coordonnées</h4>

                        <form method="POST" action="{{ route('shops.public.order', $shop) }}" @submit="submitForm" class="space-y-3">
                            @csrf
                            <input type="hidden" name="cart" x-model="cartJson">

                            <div>
                                <label class="block mb-1">Nom complet *</label>
                                <input name="customer_name" required placeholder="Ex: Aya Koné" class="w-full px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="block mb-1">Téléphone WhatsApp *</label>
                                <input name="customer_phone" required type="tel" placeholder="Ex: 07 08 09 10" class="w-full px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="block mb-1">Commune</label>
                                <input name="customer_commune" placeholder="Ex: Cocody" class="w-full px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="block mb-1">Note</label>
                                <textarea name="customer_note" rows="2" placeholder="Taille, couleur, précision..." class="w-full px-3 py-2.5 text-sm" style="resize:none;"></textarea>
                            </div>

                            <p x-show="!canOrder()" x-cloak class="text-xs rounded-xl px-3 py-2" style="background:rgba(251,191,36,0.1); color:rgba(251,191,36,0.7); border:1px solid rgba(251,191,36,0.1);">
                                Stock insuffisant sur un ou plusieurs produits.
                            </p>

                            {{-- Mode de paiement --}}
                            <div class="rounded-xl p-3.5" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.05);">
                                <p class="text-[10px] uppercase tracking-wider font-semibold mb-2.5" style="color:rgba(255,255,255,0.2);">Mode de paiement</p>
                                <div class="flex gap-2">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[11px] font-medium" style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.4); border:1px solid rgba(255,255,255,0.06);">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background:#0D99FF;"></span> Wave
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[11px] font-medium" style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.4); border:1px solid rgba(255,255,255,0.06);">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background:#FF6600;"></span> Orange
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[11px] font-medium" style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.4); border:1px solid rgba(255,255,255,0.06);">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background:#FFD500;"></span> Moov
                                    </span>
                                </div>
                                <p class="text-[10px] mt-2" style="color:rgba(255,255,255,0.15);">Paiement intégral bientôt via K-PAY</p>
                            </div>

                            <button type="submit" x-bind:disabled="!canOrder()"
                                    class="w-full py-3 rounded-xl text-white font-bold text-sm transition-colors duration-150 cursor-pointer disabled:cursor-not-allowed"
                                    style="background:#6C5CE7; opacity:1;" :style="!canOrder() && 'opacity:0.35'">
                                Confirmer la réservation — <span x-text="totalFormatted()"></span> FCFA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function cart() {
            return {
                items: [],
                showCart: false,
                init() {
                    const stored = sessionStorage.getItem('ventego_cart_' + {{ $shop->id }});
                    if (stored) {
                        try { this.items = JSON.parse(stored); } catch(e) { this.items = []; }
                    }
                },
                save() {
                    sessionStorage.setItem('ventego_cart_' + {{ $shop->id }}, JSON.stringify(this.items));
                },
                addItem(product) {
                    const existing = this.items.find(i => i.id === product.id);
                    if (existing) {
                        if (existing.quantity < product.stock) {
                            existing.quantity++;
                        }
                    } else {
                        this.items.push({ id: product.id, name: product.name, price: product.price, stock: product.stock, quantity: 1 });
                    }
                    this.save();
                    this.showCart = true;
                },
                increment(index) {
                    const item = this.items[index];
                    if (item.quantity < item.stock) {
                        item.quantity++;
                        this.save();
                    }
                },
                decrement(index) {
                    const item = this.items[index];
                    if (item.quantity > 1) {
                        item.quantity--;
                    } else {
                        this.items.splice(index, 1);
                    }
                    this.save();
                },
                remove(index) {
                    this.items.splice(index, 1);
                    this.save();
                },
                canOrder() {
                    return this.items.length > 0 && this.items.every(i => i.quantity <= i.stock);
                },
                total() {
                    return this.items.reduce((sum, i) => sum + i.price * i.quantity, 0);
                },
                totalFormatted() {
                    return this.total().toLocaleString('fr-FR');
                },
                get cartJson() {
                    return JSON.stringify(this.items.map(i => ({ id: i.id, quantity: i.quantity })));
                },
                submitForm(e) {
                    if (!this.canOrder()) {
                        e.preventDefault();
                        return;
                    }
                    sessionStorage.removeItem('ventego_cart_' + {{ $shop->id }});
                }
            }
        }
    </script>
</x-layouts.app>
