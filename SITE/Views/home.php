<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="DashMed : votre tableau de bord santé simple et moderne !">
    <title>DashMed - Accueil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/style/index.css" />
    <link rel="stylesheet" href="/assets/style/footer.css" />
    <link rel="stylesheet" href="/assets/style/header.css" />
    <link rel="stylesheet" href="/assets/style/body_main_container.css" />
    <script src="/assets/script/header_responsive.js" defer></script>
    <link rel="icon" href="/assets/images/icons/favicon.ico">
</head>
<body>
<header class="topbar">
    <div class="container">
        <div class="brand">
            <img class="logo" src="/assets/images/logo.png" alt="logo">
            <span class="brand-name">DashMed</span>
        </div>

        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/" class="current">Accueil</a>
            <a href="/map">Plan du site</a>
            <a href="/legal-notices">Mentions légales</a>
            <a href="/login" class="nav-login">Connexion</a>
        </nav>

        <a href="/login" class="login-btn">Connexion</a>

        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero__inner">
            <div class="hero__text">
                <h1>Votre tableau de bord santé, simple et moderne</h1>
                <p class="lead">
                    DashMed centralise vos données de santé pour mieux suivre vos objectifs,
                    visualiser vos progrès et rester informé.
                </p>
                <div class="cta">
                    <a class="btn btn-primary" href="/register">S’inscrire</a>
                    <a class="btn btn-ghost" href="/login">Se connecter</a>
                </div>
            </div>
            <div class="hero__illus" aria-hidden="true">
                <div class="card demo1"></div>
                <div class="card demo2"></div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Pourquoi choisir DashMed ?</h2>
            <div class="grid">
                <article class="feature">
                    <div class="icon">📊</div>
                    <h3>Suivi clair</h3>
                    <p>Des indicateurs lisibles et des graphiques pour comprendre vos mesures en un coup d’œil.</p>
                </article>
                <article class="feature">
                    <div class="icon">🔒</div>
                    <h3>Sécurité</h3>
                    <p>Vos données sont chiffrées et hébergées sur des serveurs conformes aux standards.</p>
                </article>
                <article class="feature">
                    <div class="icon">⚙️</div>
                    <h3>Personnalisable</h3>
                    <p>Adaptez vos tableaux, vos unités et vos objectifs selon votre pratique.</p>
                </article>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        © 2025 DashMed. Tous droits réservés
    </div>
</footer>
</body>
</html>
