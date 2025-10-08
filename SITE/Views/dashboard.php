<?php
$csrf_token = \Core\Csrf::token();

// Sécurité : redirection si non connecté
if (empty($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

// Exemple de données dynamiques
$activites = [
    ["label" => "Rdv avec Dr. Smith", "date" => "03/12/2025"],
    ["label" => "Résultats prise de sang", "date" => "02/12/2025"],
    ["label" => "Prescription médicaments", "date" => "01/12/2025"]
];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>DashMed - Dashboard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/style/dashboard.css">
  <link rel="stylesheet" href="/assets/style/header.css">
  <link rel="stylesheet" href="/assets/style/footer.css">
  <script src="/assets/script/header_responsive.js" defer></script>
  <link rel="icon" href="/assets/images/icons/favicon.ico">
</head>
<body>
<header class="topbar">
  <div class="inner">
    <div class="brand">
      <!-- Logo DashMed -->
      <a href="/dashboard" class="logo-link" aria-label="Page d’accueil DashMed">
        <img src="/assets/images/logo_dashmed.svg" alt="Logo DashMed" class="logo-img">
        <span class="brand-name">DashMed</span>
      </a>
    </div>

    <nav class="mainnav" aria-label="Navigation principale">
      <a href="/dashboard" class="active">Accueil</a>
      <a href="/map">Plan du site</a>
      <a href="/legal-notices">Mentions légales</a>
      <a href="/profile">Profil</a>
    </nav>

    <div class="user-actions">
      <form method="post" action="/logout" class="logout-form">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit" class="logout-btn">Déconnexion</button>
      </form>
    </div>
  </div>
</header>

<main class="layout" style="min-height: calc(100vh - 120px);">
  <section class="grid">
    <!-- Bloc Aperçu -->
    <article class="panel panel-overview">
      <h2 class="panel-title">Aperçu du Dashboard</h2>
      <p class="panel-intro">
        Obtenez un aperçu rapide de vos statistiques clés et de vos activités récentes.
      </p>
      <div class="chart-placeholder" aria-hidden="true">
        <div class="bars">
          <span style="--h:25%"></span>
          <span style="--h:40%"></span>
          <span style="--h:55%"></span>
          <span style="--h:45%"></span>
          <span style="--h:70%"></span>
          <span style="--h:50%"></span>
          <span style="--h:90%"></span>
        </div>
        <div class="trend-line"></div>
      </div>
    </article>

    <!-- Bloc Activités -->
    <aside class="panel panel-activity">
      <h2 class="panel-title">Activités récentes</h2>
      <ul class="activity-list">
        <?php foreach ($activites as $a): ?>
          <li>
            <span class="label"><?= htmlspecialchars($a["label"], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="date">- <?= htmlspecialchars($a["date"], ENT_QUOTES, 'UTF-8') ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </aside>
  </section>

  <!-- Actions rapides -->
  <section class="quick-actions-wrapper">
    <div class="quick-actions">
      <h3 class="quick-title">Actions rapides</h3>
      <div class="actions-row">
        <form method="post" action="/appointment">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
          <button class="action-btn" type="submit">Planifier un rendez-vous</button>
        </form>
        <form method="post" action="/results">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
          <button class="action-btn" type="submit">Afficher les résultats des tests</button>
        </form>
        <form method="post" action="/prescription">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
          <button class="action-btn" type="submit">Demander une ordonnance</button>
        </form>
      </div>
    </div>
  </section>
</main>

<footer class="site-footer">
  © <?= date("Y") ?> DashMed. Tous droits réservés.
</footer>
</body>
</html>
