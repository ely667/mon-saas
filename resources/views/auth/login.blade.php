<x-layouts.app title="Connexion">
    <section class="container section">
        <div class="panel" style="max-width:520px;margin:0 auto;">
            <h2>Connexion vendeur</h2>
            <form class="form" method="POST" action="{{ route('login.store') }}">
                @csrf
                <label>Email
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label>Mot de passe
                    <input type="password" name="password" required>
                </label>
                <p style="margin-top:-8px;margin-bottom:8px;">
                    <a href="{{ route('password.request') }}">Mot de passe oublie ?</a>
                </p>
                <label style="display:flex;grid-template-columns:auto 1fr;align-items:center;gap:10px;">
                    <input style="width:auto;min-height:auto;" type="checkbox" name="remember" value="1">
                    <span>Rester connecte</span>
                </label>
                <button class="btn btn-primary" type="submit">Se connecter</button>
            </form>
        </div>
    </section>
</x-layouts.app>
