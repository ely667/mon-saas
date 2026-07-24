<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'VenteGo CI' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root { color-scheme: light; --green:#0f8f5f; --dark:#15201b; --muted:#66736d; --line:#e6ece8; --bg:#f7faf8; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; background:var(--bg); color:var(--dark); }
        a { color:inherit; text-decoration:none; }
        .container { width:min(1120px, calc(100% - 32px)); margin:0 auto; }
        .nav { background:#fff; border-bottom:1px solid var(--line); position:sticky; top:0; z-index:10; }
        .nav-inner { min-height:68px; display:flex; align-items:center; justify-content:space-between; gap:16px; }
        .brand { display:flex; align-items:center; gap:10px; font-weight:800; }
        .mark { width:34px; height:34px; border-radius:8px; display:grid; place-items:center; color:white; background:var(--green); font-weight:900; }
        .nav-links { display:flex; align-items:center; gap:10px; flex-wrap:wrap; justify-content:flex-end; }
        .btn { display:inline-flex; align-items:center; justify-content:center; min-height:42px; padding:0 16px; border-radius:8px; border:1px solid transparent; font-weight:700; cursor:pointer; background:#fff; }
        .btn-primary { background:var(--green); color:#fff; }
        .btn-soft { background:#eaf7f1; color:#0d6f4b; border-color:#cbeadd; }
        .btn-line { border-color:var(--line); }
        .hero { padding:64px 0 38px; display:grid; grid-template-columns:1.1fr .9fr; gap:28px; align-items:center; }
        .eyebrow { color:var(--green); font-weight:800; text-transform:uppercase; font-size:13px; letter-spacing:.04em; }
        h1 { font-size:clamp(36px, 7vw, 70px); line-height:.98; margin:12px 0 18px; letter-spacing:0; }
        h2 { font-size:28px; margin:0 0 16px; }
        h3 { margin:0 0 8px; }
        p { color:var(--muted); line-height:1.6; }
        .panel, .card { background:#fff; border:1px solid var(--line); border-radius:8px; }
        .panel { padding:24px; }
        .grid { display:grid; gap:16px; }
        .grid-3 { grid-template-columns:repeat(3, 1fr); }
        .grid-2 { grid-template-columns:repeat(2, 1fr); }
        .stat { padding:18px; }
        .stat strong { display:block; font-size:28px; margin-top:8px; }
        .muted { color:var(--muted); }
        .section { padding:32px 0; }
        .form { display:grid; gap:14px; }
        label { display:grid; gap:7px; font-weight:700; }
        input, textarea, select { width:100%; border:1px solid var(--line); border-radius:8px; min-height:44px; padding:10px 12px; font:inherit; background:#fff; }
        textarea { min-height:110px; resize:vertical; }
        .alert { padding:12px 14px; border-radius:8px; margin:16px 0; }
        .alert-ok { background:#eaf7f1; color:#0d6f4b; }
        .alert-error { background:#fff1f1; color:#9c1b1b; }
        .table { width:100%; border-collapse:collapse; }
        .table th, .table td { padding:13px 12px; text-align:left; border-bottom:1px solid var(--line); vertical-align:top; }
        .badge { display:inline-flex; align-items:center; min-height:28px; border-radius:999px; padding:0 10px; background:#eef4f0; font-weight:700; font-size:13px; }
        .product-card { overflow:hidden; display:flex; flex-direction:column; position:relative; }
        .product-img { aspect-ratio:4/3; background:#edf3ef; display:grid; place-items:center; color:#8a9890; font-weight:800; overflow:hidden; flex-shrink:0; }
        .product-img img { width:100%; height:100%; object-fit:cover; display:block; position:relative; z-index:0; }
        .product-body { padding:16px; display:grid; gap:10px; position:relative; z-index:1; }
        .row { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
        .actions { display:flex; gap:8px; flex-wrap:wrap; }
        .footer { padding:28px 0; color:var(--muted); }
        @media (max-width: 760px) {
            [x-cloak] { display: none !important; }
            .hero, .grid-2, .grid-3 { grid-template-columns:1fr; }
            .nav-inner { align-items:flex-start; padding:14px 0; flex-direction:column; }
            .nav-links { justify-content:flex-start; }
            .table-wrap { overflow-x:auto; }
            .section { padding:20px 0; }
            h1 { font-size:clamp(28px, 6vw, 50px); }
            h2 { font-size:22px; }
            .product-body { padding:12px; }
            .product-body h3 { font-size:14px; }
            .product-body strong { font-size:15px; }
            .actions { gap:6px; }
            .actions .btn { min-height:36px; padding:0 10px; font-size:13px; }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="container nav-inner">
            <a class="brand" href="{{ route('home') }}">
                <span class="mark">V</span>
                <span>VenteGo CI</span>
            </a>
            <div class="nav-links">
                @auth
                    <a class="btn btn-line" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="btn btn-line" href="{{ route('products.index') }}">Produits</a>
                    <a class="btn btn-line" href="{{ route('orders.index') }}">Commandes</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-soft" type="submit">Déconnexion</button>
                    </form>
                @else
                    <a class="btn btn-line" href="{{ route('login') }}">Connexion</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Creer ma boutique</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <div class="container">
            @if (session('success'))
                <div class="alert alert-ok">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>

        {{ $slot }}
    </main>

    <footer class="footer">
        <div class="container">VenteGo CI - WhatsApp reste ton canal, VenteGo organise tes ventes.</div>
    </footer>
</body>
</html>
