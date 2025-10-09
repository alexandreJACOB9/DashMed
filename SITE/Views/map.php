<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Plan du site de DashMed">
    <title>Plan du site</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/style/map.css" />
    <link rel="stylesheet" href="/assets/style/footer.css" />
    <link rel="stylesheet" href="/assets/style/header.css" />
    <link rel="stylesheet" href="/assets/style/body_main_container.css" />
    <script src="/assets/script/header_responsive.js" defer></script>
    <link rel="icon" href="/assets/images/logo.png">
</head>
<body>
<header class="topbar">
    <div class="container">
        <div class="brand">
            <img class="logo" src="/assets/images/logo.png" alt="logo">
            <span class="brand-name">DashMed</span>
        </div>

        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/">Accueil</a>
            <a href="/map" class="current">Plan du site</a>
            <a href="/legal-notices">Mentions légales</a>
        </nav>

        <a href="/login" class="login-btn">Connexion</a>

        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<main class="content">
    <div class="container">
        <h1>Plan du site</h1>
        <p class="muted">Toutes les pages disponibles sur DashMed.</p>

        <nav class="sitemap" aria-label="Plan du site">
            <ul class="level-1">
                <li>
                    <a href="/">Accueil</a>
                </li>
                <li>
                    <span>Espace utilisateur</span>
                    <ul class="level-2">
                        <li><a href="/register">Inscription</a></li>
                        <li><a href="/login">Connexion</a></li>
                        <li><a href="/forgotten-password">Mot de passe oublié</a></li>
                    </ul>
                </li>
                <li>
                    <span>Informations</span>
                    <ul class="level-2">
                        <li><a href="/legal-notices">Mentions légales</a></li>
                        <li><a href="/map">Plan du site</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="tips">
            Trouvez toutes les pages du site depuis ce tableau pour naviguer plus facilement !
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© 2025 DashMed. Tous droits réservés</div>
</footer>
</body>
</html>
