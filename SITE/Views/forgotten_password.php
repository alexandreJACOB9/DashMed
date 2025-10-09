<?php /**
 * Fichier : forgotten_password.php
 *
 * Page de réinitialisation du mot de passe utilisateur pour l'application DashMed.
 * Permet à l'utilisateur de demander un lien de réinitialisation par email.
 * Utilise la structure dynamique (head, header, footer) et sécurise le formulaire via un token CSRF.
 *
 * @package DashMed
 * @version 1.1
 * @author  FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali
 */

// --- Génération du token CSRF ---
$csrf_token = \Core\Csrf::token();

// --- Variables dynamiques pour le template ---
$pageTitle = "Mot de passe oublié";
$pageDescription = "Page de mot de passe oublié, envoie un lien par mail pour le changer";
$pageStyles = [
    "/assets/style/forgotten_password.css"
];
$pageScripts = [
    "/assets/script/header_responsive.js"
];

?>
<!doctype html>
<html lang="fr">
<?php include __DIR__ . '/partials/head.php'; ?>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>


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

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
