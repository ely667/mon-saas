<x-layouts.app title="Produits">
    <section class="container section">
        <div class="row">
            <div>
                <div class="eyebrow">Catalogue</div>
                <h2>Produits</h2>
            </div>
            <a class="btn btn-primary" href="{{ route('products.create') }}">Ajouter produit</a>
        </div>

        <div class="grid grid-3 section">
            @forelse ($products as $product)
                <article class="card product-card">
                    <div class="product-img">
                        @if ($product->image_path)
                            <img src="{{ $product->image_path ? asset('storage/'.$product->image_path) : asset('images/no-image.svg') }}" alt="{{ $product->name }}">
                        @else
                            Image
                        @endif
                    </div>
                    <div class="product-body">
                        <h3>{{ $product->name }}</h3>
                        <strong>{{ number_format($product->price, 0, ',', ' ') }} FCFA</strong>
                        <span class="badge">{{ $product->is_active ? 'Visible' : 'Masque' }}</span>
                        <div class="actions">
                            <a class="btn btn-line" href="{{ route('products.edit', $product) }}">Modifier</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-line" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="panel">
                    <h3>Aucun produit</h3>
                    <p>Ajoute ton premier article pour rendre ta boutique publique utile.</p>
                </div>
            @endforelse
        </div>

        {{ $products->links() }}
    </section>
</x-layouts.app>
