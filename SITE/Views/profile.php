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
    <meta name="description" content="Consultez votre profil DashMed une fois connecter">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/style/body_main_container.css">
    <link rel="stylesheet" href="/assets/style/header.css">
    <link rel="stylesheet" href="/assets/style/footer.css">
    <link rel="stylesheet" href="/assets/style/profile.css">
    <script src="/assets/script/header_responsive.js" defer></script>
    <link rel="icon" href="/assets/images/logo.png">
</head>
<body>
<header class="topbar">
    <div class="container">
        <div class="brand">
            <img src="/assets/images/logo.png" alt="Logo" class="logo">
            <span class="brand-name">DashMed</span>
        </div>

        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/dashboard">Accueil</a>
            <a href="/profile" class="current">Profil</a>
            <a href="/logout" class="nav-login">Déconnexion</a>
        </nav>

        <a href="/logout" class="login-btn">Déconnexion</a>

        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>

<main>
    <div class="container">
        <h1 class="profile-title">Profil</h1>

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
                        <a class="btn-edit" href="">Modifier</a>
                    </td>
                </tr>
                </tbody>
            </table>
            <a class="btn-delete" href="">Supprimer mon compte</a>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        © 2025 DashMed. Tous droits réservés
    </div>
</footer>
</body>
</html>
