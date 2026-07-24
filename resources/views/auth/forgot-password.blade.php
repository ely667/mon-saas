<x-layouts.app title="Mot de passe oublie">
    <section class="container section">
        <div class="panel" style="max-width:520px;margin:0 auto;">
            <h2>Mot de passe oublie</h2>
            <p>Entre ton adresse email et nous t'enverrons un lien pour reinitialiser ton mot de passe.</p>

            @if (session('status'))
                <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:6px;margin-bottom:16px;">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <label>Email
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </label>
                <button class="btn btn-primary" type="submit">Envoyer le lien</button>
            </form>

            <p style="margin-top:16px;text-align:center;">
                <a href="{{ route('login') }}">Retour a la connexion</a>
            </p>
        </div>
    </section>
</x-layouts.app>
