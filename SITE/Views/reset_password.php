<?php $csrf_token = \Core\Csrf::token(); ?>
<!doctype html>
<html lang="fr">
<?php
$pageTitle = "Plan du site";
$pageDescription = "Plan du site de DashMed !";
$pageStyles = ["/assets/style/map.css"];
$pageScripts = [];
include __DIR__ . '/partials/head.php';
?>
<body>
    
<?php include __DIR__ . '/partials/header.php'; ?>

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

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
