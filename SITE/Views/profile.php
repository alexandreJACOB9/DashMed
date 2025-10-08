<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$user = $_SESSION['user'];
$parts = preg_split('/\s+/', trim($user['name'] ?? ''), 2);
$first = $parts[0] ?? '';
$last  = $parts[1] ?? '';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style/header.css">
    <link rel="stylesheet" href="/assets/style/footer.css">
    <link rel="stylesheet" href="/assets/style/profile.css">
</head>
<body>
<header class="topbar">
    <div class="container">
        <a class="brand" href="/"><img src="/assets/images/logo.png" alt="Logo" class="logo" width="34" height="34"><span class="brand-name">DashMed</span></a>
        <nav class="mainnav">
            <a href="/dashboard">Accueil</a>
            <a href="/map">Plan du site</a>
            <a href="/legal-notices">Mentions légales</a>
            <?php if (!empty($_SESSION['user'])): ?>
                <a href="/profile" class="active">Profil</a>
                <a href="/logout">Déconnexion</a>
            <?php else: ?>
                <a href="/login">Connexion</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="profile-wrapper">
    <h1>Profil</h1>

    <div class="profile-card">
        <div class="avatar">
            <div class="avatar-circle" aria-hidden="true">👤</div>
        </div>
        <table class="info-table" aria-describedby="profil-infos">
            <tbody>
            <tr>
                <th scope="row">Prénom</th>
                <td><?= htmlspecialchars($first) ?></td>
            </tr>
            <tr>
                <th scope="row">Nom</th>
                <td><?= htmlspecialchars($last) ?></td>
            </tr>
            <tr>
                <th scope="row">Adresse email</th>
                <td class="email-cell">
                    <span><?= htmlspecialchars($user['email']) ?></span>
                    <a class="btn-edit" href="/profile/edit">Modifier</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</main>

<footer class="footer">
    <p>© 2025 DashMed. Tous droits réservés</p>
</footer>
</body>
</html>