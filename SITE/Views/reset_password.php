<?php $csrf_token = \Core\Csrf::token(); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>DashMed - Réinitialisation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page pour réinitialiser le mot de passe oublié et définir un nouveau">

    <link rel="stylesheet" href="/assets/style/forgotten_password.css">
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
            <a href="/legal-notices">Mentions légales</a>
        </nav>
        <a href="/login" class="login-btn">Connexion</a>
    </div>
</header>

<main class="main">
    <section class="hero">
        <h1>Définissez un nouveau mot de passe</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul class="errors">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form class="form" action="/reset-password" method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <div class="field">
                <input type="password" name="password" placeholder="Nouveau mot de passe" required>
            </div>
            <div class="field">
                <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" required>
            </div>
            <button class="btn" type="submit">Changer mon mot de passe</button>
        </form>
    </section>
</main>

<footer class="footer">
    <div class="container">© 2025 DashMed. Tous droits réservés</div>
</footer>
</body>
</html>