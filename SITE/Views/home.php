/**
 * Fichier : index.php
 * Page d'accueil de l'application DashMed.
 *
 * Présente le service et ses avantages, invite à l'inscription ou à la connexion.
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
 * @author  FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali
 */
<!doctype html>
<html lang="fr">
<?php
// Variables dynamiques transmises depuis le contrôleur
$pageTitle = $pageTitle ?? "Accueil";
$pageDescription = $pageDescription ?? "Page d'accueil de DashMed : votre tableau de bord santé simple et moderne pour la médecine";
$pageStyles = $pageStyles ?? ["/assets/style/index.css"];
$pageScripts = $pageScripts ?? [];
include __DIR__ . '/partials/head.php';
?>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>
<main>
    <section class="hero">
        <div class="container hero__inner">
            <div class="hero__text">
                <h1>Votre tableau de bord santé, simple et moderne</h1>
                <p class="lead">
                    DashMed centralise vos données de santé pour mieux suivre vos objectifs,
                    visualiser vos progrès et rester informé.
                </p>
                <div class="cta">
                    <a class="btn btn-primary" href="/register">S’inscrire</a>
                    <a class="btn btn-ghost" href="/login">Se connecter</a>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Pourquoi choisir DashMed ?</h2>
            <div class="grid">
                <article class="feature">
                    <div class="icon">📊</div>
                    <h3>Suivi clair</h3>
                    <p>Des indicateurs lisibles et des graphiques pour comprendre vos mesures en un coup d’œil.</p>
                </article>
                <article class="feature">
                    <div class="icon">🔒</div>
                    <h3>Sécurité</h3>
                    <p>Vos données sont chiffrées et hébergées sur des serveurs conformes aux standards.</p>
                </article>
                <article class="feature">
                    <div class="icon">⚙️</div>
                    <h3>Personnalisable</h3>
                    <p>Adaptez vos tableaux, vos unités et vos objectifs selon votre pratique.</p>
                </article>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
