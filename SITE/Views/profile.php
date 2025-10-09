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
<?php
$pageTitle = "Profil";
$pageDescription = "Consultez votre profil DashMed une fois connecter";
$pageStyles = ["/assets/style/profile.css"];
$pageScripts = [];
include __DIR__ . '/partials/head.php';
?>
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

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
