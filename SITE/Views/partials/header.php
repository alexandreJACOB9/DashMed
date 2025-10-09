<header class="topbar">
    <div class="container">
        <div class="brand">
            <img class="logo" src="/assets/images/logo.png" alt="logo">
            <span class="brand-name">DashMed</span>
        </div>
        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/"<?= ($_SERVER['REQUEST_URI'] === '/' ? ' class="current"' : '') ?>>Accueil</a>
            <a href="/map"<?= (strpos($_SERVER['REQUEST_URI'], '/map') !== false ? ' class="current"' : '') ?>>Plan du site</a>
            <a href="/legal-notices"<?= (strpos($_SERVER['REQUEST_URI'], '/legal-notices') !== false ? ' class="current"' : '') ?>>Mentions légales</a>
        </nav>
        <a href="/login" class="login-btn">Connexion</a>
        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
