<x-layouts.app title="Modifier produit">
    <section class="container section">
        <div class="panel" style="max-width:760px;margin:0 auto;">
            <h2>Modifier {{ $product->name }}</h2>
            @include('products.partials.form', ['product' => $product, 'action' => route('products.update', $product), 'method' => 'PUT'])
        </div>
    </section>
</x-layouts.app>
