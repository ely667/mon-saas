<x-layouts.app title="Parametres boutique">
    <section class="container section">
        <div class="panel" style="max-width:760px;margin:0 auto;">
            <h2>Parametres boutique</h2>
            <p>Lien public : <a href="{{ route('shops.public.show', $shop) }}"><strong>{{ route('shops.public.show', $shop) }}</strong></a></p>
            <form class="form" method="POST" action="{{ route('shop.settings.update') }}">
                @csrf
                @method('PATCH')
                <label>Nom boutique
                    <input name="name" value="{{ old('name', $shop->name) }}" required>
                </label>
                <label>Numero WhatsApp
                    <input name="whatsapp_phone" value="{{ old('whatsapp_phone', $shop->whatsapp_phone) }}" required>
                </label>
                <label>Ville
                    <input name="city" value="{{ old('city', $shop->city) }}">
                </label>
                <label>Commune
                    <input name="commune" value="{{ old('commune', $shop->commune) }}">
                </label>
                <label>Lien logo
                    <input type="url" name="logo_path" value="{{ old('logo_path', $shop->logo_path) }}">
                </label>
                <label>Description
                    <textarea name="description">{{ old('description', $shop->description) }}</textarea>
                </label>
                <label style="display:flex;grid-template-columns:auto 1fr;align-items:center;gap:10px;">
                    <input style="width:auto;min-height:auto;" type="checkbox" name="is_public" value="1" @checked(old('is_public', $shop->is_public))>
                    <span>Boutique publique</span>
                </label>
                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </section>
</x-layouts.app>
