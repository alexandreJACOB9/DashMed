<?php $csrf_token = \Core\Csrf::token(); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Mot de passe oublié ? Changez-le !">
    <title>DashMed - Mot de passe oublié</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/style/forgotten_password.css" />
    <link rel="stylesheet" href="/assets/style/footer.css" />
    <link rel="stylesheet" href="/assets/style/header.css" />
    <link rel="stylesheet" href="/assets/style/body_main_container.css" />
    <script src="/assets/script/header_responsive.js" defer></script>
    <link rel="icon" href="/assets/images/icons/favicon.ico">
    <style>
        .alert { padding: 12px 14px; border-radius: 6px; margin-bottom: 16px; }
        .alert-error { background:#fde2e1; color:#8b1a15; border:1px solid #f7b4b1; }
        .alert-success { background:#e6f6e6; color:#256029; border:1px solid #b5e0b7; }
        .errors { margin:0; padding-left:18px; }
    </style>
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
            <a href="/map">Plan du site</a>
            <a href="/legal">Mentions légales</a>
            <a href="/login" class="nav-login">Connexion</a>
        </nav>
        <a href="/login" class="login-btn">Connexion</a>
        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<main class="main">
    <section class="hero">
        <h1>Réinitialisez votre mot de passe</h1>
        <p class="subtitle">Entrez votre adresse email ci-dessous et vous recevrez un lien pour changer de mot de passe.</p>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul class="errors">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form" action="/forgotten-password" method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <div class="field">
                <input type="email" name="email" placeholder="Adresse email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" />
            </div>
            <button class="btn" type="submit">Envoyer le lien</button>
        </form>
    </section>
</main>

<footer class="footer">
    <div class="container">© 2025 DashMed. Tous droits réservés</div>
</footer>
</body>
</html>
