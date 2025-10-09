<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<header class="topbar">
    <div class="container">
        <!-- Logo et nom de la marque -->
        <div class="brand">
            <img class="logo" src="/assets/images/logo.png" alt="Logo DashMed">
            <span class="brand-name">DashMed</span>
        </div>

        <!-- Navigation principale -->
        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/"<?= ($currentPath === '/' ? ' class="current"' : '') ?>>Accueil</a>
            <a href="/map"<?= ($currentPath === '/map' ? ' class="current"' : '') ?>>Plan du site</a>
            <a href="/legal-notices"<?= ($currentPath === '/legal-notices' ? ' class="current"' : '') ?>>Mentions légales</a>
        </nav>

        <!-- Bouton de connexion/déconnexion -->
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="/logout" class="login-btn">Déconnexion</a>
        <?php else: ?>
            <a href="/login" class="login-btn">Connexion</a>
        <?php endif; ?>

        <!-- Burger menu pour responsive -->
        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
