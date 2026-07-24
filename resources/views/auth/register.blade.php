<x-layouts.app title="Creer ma boutique">
    <section class="container section">
        <div class="panel" style="max-width:720px;margin:0 auto;">
            <h2>Creer ta boutique VenteGo</h2>
            <p>En 2 minutes, tu obtiens ton espace vendeur et ton lien public.</p>
            <form class="form" method="POST" action="{{ route('register.store') }}">
                @csrf
                <label>Ton nom
                    <input name="name" value="{{ old('name') }}" required>
                </label>
                <label>Email
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label>Mot de passe
                    <input type="password" name="password" required minlength="8">
                </label>
                <label>Nom de la boutique
                    <input name="shop_name" value="{{ old('shop_name') }}" placeholder="Ex: Aicha Fashion" required>
                </label>
                <label>Numero WhatsApp
                    <input name="whatsapp_phone" value="{{ old('whatsapp_phone') }}" placeholder="Ex: 0700000000" required>
                </label>
                <label>Commune
                    <input name="commune" value="{{ old('commune') }}" placeholder="Ex: Yopougon">
                </label>
                <button class="btn btn-primary" type="submit">Creer ma boutique</button>
            </form>
        </div>
    </section>
</x-layouts.app>
