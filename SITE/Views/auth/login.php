<?php
use Core\Csrf;
$csrf_token = Csrf::token();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion - DashMed</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:system-ui;margin:0;padding:24px;background:#0f172a;color:#e5e7eb}
    .wrap{max-width:480px;margin:0 auto}
    .card{background:#111827;border:1px solid #1f2937;border-radius:12px;padding:16px}
    .field{display:grid;gap:6px;margin-bottom:12px}
    input,button{font:inherit;padding:10px 12px;border-radius:8px;border:1px solid #374151;background:#0b1220;color:#e5e7eb}
    button{cursor:pointer}
    .alert{padding:10px 12px;border-radius:8px;margin-bottom:12px}
    .error{background:#43191a;border:1px solid #7f1d1d}
    a{color:#22d3ee}
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Connexion</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert error">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="card">
      <form method="post" action="/login">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="field">
          <label>Mot de passe</label>
          <input type="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
      </form>
    </div>

    <p>Pas de compte ? <a href="/">Créer un compte</a></p>
  </div>
</body>
</html>
