<?php
/**
 * Fichier : inscription.php
 * Page d'inscription utilisateur de l'application DashMed.
 *
 * Permet à l'utilisateur de créer un compte en saisissant son prénom, nom, email et mot de passe.
 * Le formulaire est sécurisé via un token CSRF. Affiche également les messages d'erreur ou de succès.
 *
 * Variables :
 * - $csrf_token (string)  Token CSRF pour sécuriser le formulaire
 * - $errors     (array)   Liste des erreurs de saisie
 * - $success    (string)  Message de succès
 * - $old        (array)   Valeurs précédemment saisies (ex: name, last_name, email)
 *
 * @package DashMed
 * @version 1.0
 * @author FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali
 */

use Core\Csrf;
$csrf_token = Csrf::token();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Créez votre compte DashMed !">
    <title>Inscription</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/style/authentication.css" />
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
            <a href="/map">Plan du site</a>
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

<main class="main">
    <section class="hero">
        <h1>Bienvenue dans DashMed</h1>
        <p class="subtitle">Créez votre compte</p>

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

        <form class="form" action="/inscription" method="post" autocomplete="on" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>"/>

            <div class="field">
                <input type="text" name="name" placeholder="Prénom" required value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" />
            </div>

            <div class="field">
                <input type="text" name="last_name" placeholder="Nom" required value="<?= htmlspecialchars($old['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" />
            </div>

            <div class="field">
                <input type="email" name="email" placeholder="Adresse email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" />
            </div>

            <div class="field">
                <input type="password" name="password" placeholder="Mot de passe" required />
            </div>

            <div class="field">
                <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" required />
            </div>

            <button class="btn" type="submit">S’inscrire</button>
        </form>
    </section>
</main>

<footer class="footer">
    <div class="container">
        © 2025 DashMed. Tous droits réservés
    </div>
</footer>
</body>
</html>
