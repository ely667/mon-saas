<x-layouts.app title="Dashboard">
    <section class="container section">
        <div class="row">
            <div>
                <div class="eyebrow">Espace vendeur</div>
                <h2>{{ $shop->name }}</h2>
                <p>Ton lien public : <a href="{{ route('shops.public.show', $shop) }}"><strong>{{ route('shops.public.show', $shop) }}</strong></a></p>
            </div>
            <div class="actions">
                <a class="btn btn-soft" href="{{ route('shops.public.show', $shop) }}">Voir boutique</a>
                <a class="btn btn-primary" href="{{ route('products.create') }}">Ajouter produit</a>
            </div>
        </div>

        <div class="grid grid-3 section">
            <div class="stat card"><span class="muted">Produits</span><strong>{{ $productsCount }}</strong></div>
            <div class="stat card"><span class="muted">Commandes</span><strong>{{ $ordersCount }}</strong></div>
            <div class="stat card"><span class="muted">En attente</span><strong>{{ $pendingOrdersCount }}</strong></div>
        </div>

        <div class="grid grid-2">
            <div class="panel">
                <h3>Commandes recentes</h3>
                @forelse ($latestOrders as $order)
                    <p><strong>{{ $order->customer_name }}</strong> - {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA - {{ $order->statusLabel() }}</p>
                @empty
                    <p>Aucune commande pour le moment. Partage ton lien en statut WhatsApp.</p>
                @endforelse
            </div>
            <div class="panel">
                <h3>Prochaine action</h3>
                <p>Ajoute 3 a 5 produits, ouvre ta boutique publique, puis filme le parcours client complet.</p>
                <a class="btn btn-line" href="{{ route('shop.settings.edit') }}">Parametres boutique</a>
            </div>
        </div>
    </section>
</x-layouts.app>
