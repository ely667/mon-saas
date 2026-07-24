<x-layouts.app title="Reinitialiser le mot de passe">
    <section class="container section">
        <div class="panel" style="max-width:520px;margin:0 auto;">
            <h2>Nouveau mot de passe</h2>
            <p>Choisis un nouveau mot de passe pour ton compte.</p>

            <form class="form" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <label>Nouveau mot de passe
                    <input type="password" name="password" required autofocus minlength="8">
                </label>
                <label>Confirmer le mot de passe
                    <input type="password" name="password_confirmation" required minlength="8">
                </label>
                <button class="btn btn-primary" type="submit">Reinitialiser</button>
            </form>
        </div>
    </section>
</x-layouts.app>
