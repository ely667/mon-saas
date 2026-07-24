<x-layouts.app title="Ajouter produit">
    <section class="container section">
        <div class="panel" style="max-width:760px;margin:0 auto;">
            <h2>Ajouter un produit</h2>
            @include('products.partials.form', ['product' => null, 'action' => route('products.store'), 'method' => 'POST'])
        </div>
    </section>
</x-layouts.app>
