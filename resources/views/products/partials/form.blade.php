<form class="form" method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif
    <label>Nom du produit
        <input name="name" value="{{ old('name', $product?->name) }}" required>
    </label>
    <label>Prix en FCFA
        <input type="number" min="0" name="price" value="{{ old('price', $product?->price) }}" required>
    </label>
    <label>Stock
        <input type="number" min="0" name="stock" value="{{ old('stock', $product?->stock) }}">
    </label>
    <label>Image du produit
        @if ($product?->image_path)
            <div style="margin-bottom:8px;">
                <img src="{{ asset('storage/'.$product->image_path) }}" alt="Image actuelle" style="max-width:200px;border-radius:6px;">
            </div>
        @endif
        <input type="file" name="image" accept="image/*">
    </label>
    <label>Description
        <textarea name="description">{{ old('description', $product?->description) }}</textarea>
    </label>
    <label style="display:flex;grid-template-columns:auto 1fr;align-items:center;gap:10px;">
        <input style="width:auto;min-height:auto;" type="checkbox" name="is_active" value="1" @checked(old('is_active', $product?->is_active ?? true))>
        <span>Visible dans la boutique</span>
    </label>
    <button class="btn btn-primary" type="submit">Enregistrer</button>
</form>
