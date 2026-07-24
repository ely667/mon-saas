<x-layouts.app :title="$product->name . ' — ' . $shop->name">

    <style>
        body { background: #0F0F17 !important; }
        .nav { display: none !important; }
        .footer { display: none !important; }
        main > .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        img { max-width:100% !important; height:auto !important; }
    </style>

    <div x-data="cart()" x-init="init()" class="min-h-screen text-white" style="background:#0F0F17;">

        {{-- HEADER --}}
        <header class="fixed top-0 inset-x-0 z-50 border-b border-white/5" style="background:rgba(15,15,23,0.82); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px);">
            <div class="flex items-center justify-between px-4 h-13">
                <a href="{{ route('shops.public.show', $shop) }}" class="flex items-center gap-2 min-w-0 text-white/60 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span class="text-sm font-medium truncate">{{ $shop->name }}</span>
                </a>
                <button @click="showCart = true" class="relative flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <span x-show="items.length > 0" x-cloak class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-[#6C5CE7] text-white text-[9px] font-bold rounded-full flex items-center justify-center" x-text="items.length"></span>
                </button>
            </div>
        </header>

        {{-- IMAGE --}}
        <section class="pt-13">
            <div class="w-full aspect-square max-h-[70vh] overflow-hidden" style="background:#252540;">
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" style="width:100%;height:100%;object-fit:cover;display:block;">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>
        </section>

        {{-- DETAILS --}}
        <section class="px-4 py-6 max-w-lg mx-auto">
            <div class="flex items-start justify-between gap-3 mb-2">
                <h1 class="text-xl font-extrabold text-white leading-tight flex-1">{{ $product->name }}</h1>
                @if($product->stock <= 0)
                    <span class="flex-shrink-0 text-[11px] font-semibold px-2.5 py-1 rounded-full" style="background:rgba(239,68,68,0.12); color:#f87171; border:1px solid rgba(239,68,68,0.2);">Rupture</span>
                @endif
            </div>

            <p class="text-2xl font-extrabold mb-4" style="color:#A78BFA;">
                {{ number_format($product->price, 0, ',', ' ') }} <span class="text-sm font-medium" style="color:rgba(167,139,250,0.5);">FCFA</span>
            </p>

            @if($product->description)
                <div class="rounded-2xl p-4 mb-5" style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.06);">
                    <p class="text-xs uppercase tracking-wider font-semibold mb-2" style="color:rgba(255,255,255,0.25);">Description</p>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.55);">{{ $product->description }}</p>
                </div>
            @endif

            @if($product->stock > 0)
                <div class="flex items-center gap-2 mb-5 text-xs" style="color:rgba(255,255,255,0.35);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    {{ $product->stock }} en stock
                </div>
            @endif

            {{-- AJOUTER AU PANIER --}}
            @if($product->stock > 0)
                <button
                    x-on:click="addItem({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'stock' => $product->stock]) }})"
                    class="w-full py-3.5 rounded-xl text-white font-bold text-sm transition-colors duration-150 cursor-pointer flex items-center justify-center gap-2"
                    style="background:#6C5CE7;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Ajouter au panier
                </button>
            @else
                <button disabled class="w-full py-3.5 rounded-xl text-sm font-semibold cursor-not-allowed" style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.2);">
                    Indisponible
                </button>
            @endif
        </section>

        {{-- PANIER (drawer) --}}
        <div x-show="showCart" x-cloak
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-end sm:items-center justify-center">

            <div class="absolute inset-0" style="background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);" @click="showCart = false"></div>

            <div class="relative w-full sm:max-w-md sm:rounded-2xl rounded-t-2xl max-h-[88vh] flex flex-col" style="background:#1A1A2E; border:1px solid rgba(255,255,255,0.06);"
                 x-show="showCart"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-full sm:translate-y-0 sm:scale-95 sm:opacity-0" x-transition:enter-end="translate-y-0 sm:scale-100 sm:opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-y-0 sm:scale-100 sm:opacity-100" x-transition:leave-end="translate-y-full sm:translate-y-0 sm:scale-95 sm:opacity-0">

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
                    <div x-show="items.length === 0" class="text-center py-10">
                        <svg class="w-12 h-12 mx-auto mb-3" style="color:rgba(255,255,255,0.08);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <p class="text-sm font-medium" style="color:rgba(255,255,255,0.3);">Ton panier est vide</p>
                    </div>

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

                    <div x-show="items.length > 0" class="mt-5 pt-5" style="border-top:1px solid rgba(255,255,255,0.06);">
                        <h4 class="font-bold text-xs mb-4" style="color:rgba(255,255,255,0.5);">Tes coordonnées</h4>

                        <form method="POST" action="{{ route('shops.public.order', $shop) }}" @submit="submitForm" class="space-y-3">
                            @csrf
                            <input type="hidden" name="cart" x-model="cartJson">

                            <div>
                                <label class="block mb-1" style="color:rgba(255,255,255,0.45); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.05em;">Nom complet *</label>
                                <input name="customer_name" required placeholder="Ex: Aya Koné" class="w-full px-3 py-2.5 text-sm" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08); color:#fff; border-radius:12px;">
                            </div>
                            <div>
                                <label class="block mb-1" style="color:rgba(255,255,255,0.45); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.05em;">Téléphone WhatsApp *</label>
                                <input name="customer_phone" required type="tel" placeholder="Ex: 07 08 09 10" class="w-full px-3 py-2.5 text-sm" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08); color:#fff; border-radius:12px;">
                            </div>
                            <div>
                                <label class="block mb-1" style="color:rgba(255,255,255,0.45); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.05em;">Commune</label>
                                <input name="customer_commune" placeholder="Ex: Cocody" class="w-full px-3 py-2.5 text-sm" style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08); color:#fff; border-radius:12px;">
                            </div>
                            <div>
                                <label class="block mb-1" style="color:rgba(255,255,255,0.45); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.05em;">Note</label>
                                <textarea name="customer_note" rows="2" placeholder="Taille, couleur, précision..." class="w-full px-3 py-2.5 text-sm" style="resize:none; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08); color:#fff; border-radius:12px;"></textarea>
                            </div>

                            <p x-show="!canOrder()" x-cloak class="text-xs rounded-xl px-3 py-2" style="background:rgba(251,191,36,0.1); color:rgba(251,191,36,0.7); border:1px solid rgba(251,191,36,0.1);">
                                Stock insuffisant sur un ou plusieurs produits.
                            </p>

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
                        this.items.push({ id: product.id, name: product.name, price: product.price, stock: product.stock, quantity: 1, priceFormatted: product.price.toLocaleString('fr-FR') });
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
