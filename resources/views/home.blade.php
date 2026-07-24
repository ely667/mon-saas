<x-layouts.app title="VenteGo CI">
    <section class="container hero">
        <div>
            <div class="eyebrow">WhatsApp commerce pour la Cote d'Ivoire</div>
            <h1>Transforme ton WhatsApp en boutique professionnelle.</h1>
            <p>VenteGo aide les vendeurs a creer un catalogue public, partager un lien ou QR code, recevoir les commandes et repondre sur WhatsApp sans perdre les clients.</p>
            <div class="actions">
                <a class="btn btn-primary" href="{{ route('register') }}">Creer ma boutique</a>
                <a class="btn btn-line" href="{{ route('login') }}">J'ai deja un compte</a>
            </div>
        </div>
        <div class="panel">
            <div class="eyebrow">Scenario V1</div>
            <h2>Catalogue, commande, WhatsApp.</h2>
            <p>Le vendeur ajoute ses produits une fois. Le client ouvre le lien, commande, puis le vendeur voit tout dans son dashboard.</p>
            <div class="grid">
                <div class="stat card"><span class="muted">Prix de lancement</span><strong>3 000 FCFA</strong><span class="muted">par mois</span></div>
                <div class="stat card"><span class="muted">Essai</span><strong>7 jours</strong><span class="muted">pour tester</span></div>
            </div>
        </div>
    </section>
</x-layouts.app>
