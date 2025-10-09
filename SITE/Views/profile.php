<?php
/**
 * Fichier : profile.php
 * Page de profil utilisateur de l'application DashMed.
 *
 * Affiche les informations de l'utilisateur connecté (nom, prénom, email) et propose
 * des actions sur le compte (modifier email, supprimer compte). Sécurisée via session utilisateur.
 * Utilise la structure dynamique avec head, header et footer inclus.
 *
 * Variables dynamiques :
 * - $pageTitle       (string)  Titre de la page
 * - $pageDescription (string)  Description pour les métadonnées
 * - $pageStyles      (array)   Styles CSS spécifiques
 * - $pageScripts     (array)   Scripts JS spécifiques
 *
 * @package DashMed
 * @version 1.0
 * @author FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali
 */

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

$user = $_SESSION['user'];
$parts = preg_split('/\s+/', trim($user['name'] ?? ''), 2);
$first = $parts[0] ?? '';
$last  = $parts[1] ?? '';

$pageTitle = "Profil";
$pageDescription = "Consultez votre profil DashMed une fois connecté";
$pageStyles = ["/assets/style/profile.css"];
$pageScripts = [];

include __DIR__ . '/partials/head.php';
?>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>

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
