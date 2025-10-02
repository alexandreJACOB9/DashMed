<?php
declare(strict_types=1);

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_name('dashmed_session');
session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lib/csrf.php';

$errors = [];
$success = '';
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Session expirée ou jeton CSRF invalide. Veuillez réessayer.';
    }

    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $password_confirm = (string)($_POST['password_confirm'] ?? '');

    if ($name === '') {
        $errors[] = 'Le nom est obligatoire.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse email invalide.';
    }
    if (
        strlen($password) < 12 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/\d/', $password)
    ) {
        $errors[] = 'Le mot de passe doit contenir au moins 12 caractères, avec des lettres majuscules, minuscules et des chiffres.';
    }
    if ($password !== $password_confirm) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    if (!$errors) {
        try {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = 'Un compte existe déjà avec cette adresse email.';
            }
        } catch (Throwable $e) {
            $errors[] = "Erreur interne lors de la vérification de l'email.";
        }
    }

    if (!$errors) {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $now = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, created_at, updated_at) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $email, $hash, $now, $now]);

            $success = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
            $name = '';
            $email = '';
        } catch (Throwable $e) {
            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1062) {
                $errors[] = 'Cette adresse email est déjà utilisée.';
            } else {
                $errors[] = 'Erreur lors de la création du compte.';
            }
        }
    }
}

$csrf_token = csrf_token();

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Correction de l’attribut meta name -->
    <meta name="description" content="Pas de compte pour utiliser DashMed ? Inscrivez-vous !">
    <title>DashMed - Inscription</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Adapte les chemins si besoin selon l’emplacement de ce fichier -->
    <link rel="stylesheet" href="../Public/assets/style/registration.css" />
    <link rel="stylesheet" href="../Public/assets/style/footer.css" />
    <link rel="stylesheet" href="../Public/assets/style/header.css" />
    <link rel="icon" href="../Public/assets/images/icons/favicon.ico">

    <style>
        /* Petites classes pour messages */
        .alert { padding: 12px 14px; border-radius: 6px; margin-bottom: 16px; }
        .alert-error { background: #fde2e1; color: #8b1a15; border: 1px solid #f7b4b1; }
        .alert-success { background: #e6f6e6; color: #256029; border: 1px solid #b5e0b7; }
        .errors { margin: 0; padding-left: 18px; }
    </style>
</head>
<body>

<header class="topbar">
    <div class="container">
        <div class="brand">
            <img class="logo" src="../../../DashMed/SITE/Public/assets/images/logo.png" alt="logo">
            <span class="brand-name">DashMed</span>
        </div>

        <nav class="mainnav" aria-label="Navigation principale">
            <a href="#">Accueil</a>
            <a href="#">Plan du site</a>
            <a href="#">Mentions légales</a>
        </nav>

        <a href="login.php">Connexion</a>
    </div>
</header>

<main class="main">
    <section class="hero">
        <h1>Bienvenue dans DashMed</h1>
        <p class="subtitle">Créez votre compte</p>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <ul class="errors">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="form" action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') ?>" method="post" autocomplete="on" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>"/>

            <div class="field">
                <input type="text" name="name" placeholder="Nom" required value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" />
            </div>

            <div class="field">
                <input type="email" name="email" placeholder="Adresse email" required value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" />
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
