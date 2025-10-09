<?php
/**
 * Fichier : dashboard.php
 *
 * Page du tableau de bord utilisateur pour l'application DashMed.
 * Affiche les statistiques, les activités récentes et propose des actions rapides.
 * Sécurise l'accès via session utilisateur et token CSRF.
 * Utilise les partials pour le head et le footer.
 *
 * @package DashMed
 * @version 1.1
 * @author FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali
 */

/**
 * Génère le token CSRF pour la sécurité des formulaires.
 * @var string $csrf_token
 */
$csrf_token = \Core\Csrf::token();

/**
 * Vérifie la présence de la session utilisateur.
 * Redirige vers la page de connexion si l'utilisateur n'est pas authentifié.
 */
if (empty($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

/**
 * Variables dynamiques pour le template de la page.
 * 
 * @var string $pageTitle       Titre de la page (balise <title>)
 * @var string $pageDescription Description pour la balise <meta name="description">
 * @var array  $pageStyles      Liste des feuilles de style spécifiques à la page
 * @var array  $pageScripts     Liste des scripts spécifiques à la page
 */
$pageTitle = "Tableau de bord";
$pageDescription = "Page du dashboard accessible une fois connecter, espace pour vorir l'activité et les informations des médecins";
$pageStyles = [
    "/assets/style/dashboard.css"
];
$pageScripts = [
    "/assets/script/header_responsive.js"
];

/**
 * Activités récentes affichées sur le dashboard.
 * 
 * @var array $activites Chaque élément est un tableau associatif avec les clés :
 *                       - 'label' : string, description de l'activité
 *                       - 'date'  : string, date de l'activité au format JJ/MM/AAAA
 */
$activites = [
    ["label" => "Rdv avec Dr. Smith", "date" => "03/12/2025"],
    ["label" => "Résultats prise de sang", "date" => "02/12/2025"],
    ["label" => "Prescription médicaments", "date" => "01/12/2025"]
];
?>
<!doctype html>
<html lang="fr">
<?php include __DIR__ . '/partials/head.php'; ?>

<body>
<header class="topbar">
    <div class="container">
        <div class="brand">
            <img src="/assets/images/logo.png" alt="Logo" class="logo">
            <span class="brand-name">DashMed</span>
        </div>

        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/dashboard" class="current">Accueil</a>
            <a href="/profile">Profil</a>
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
        <section class="grid">
            <!-- Bloc Aperçu du dashboard -->
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

            <!-- Bloc Activités récentes -->
            <aside class="panel-activity">
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

        <!-- Section Actions rapides -->
        <section class="quick-actions-wrapper">
            <div class="quick-actions">
                <h3 class="quick-title">Actions rapides</h3>
                <div class="actions-row">
                    <!-- Formulaire pour planifier un rendez-vous -->
                    <form method="post" action="/appointment">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button class="action-btn" type="submit">Planifier un rendez-vous</button>
                    </form>
                    <!-- Formulaire pour afficher les résultats des tests -->
                    <form method="post" action="/results">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button class="action-btn" type="submit">Afficher les résultats des tests</button>
                    </form>
                    <!-- Formulaire pour demander une ordonnance -->
                    <form method="post" action="/prescription">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <button class="action-btn" type="submit">Demander une ordonnance</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
