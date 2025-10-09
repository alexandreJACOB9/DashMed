<?php
/**
 * Fichier : legal-notices.php
 * Page des mentions légales de l'application DashMed.
 *
 * Fournit les informations réglementaires concernant l'éditeur, l'hébergement, la propriété intellectuelle,
 * la confidentialité, les cookies et la responsabilité. Utilise la structure dynamique avec head, header et footer inclus.
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

$pageTitle = "Mentions légales";
$pageDescription = "Toutes les mentions légales de DashMed";
$pageStyles = ["/assets/style/legal_notices.css"];
$pageScripts = [];

include __DIR__ . '/partials/head.php';
?>
<body>
<?php include __DIR__ . '/partials/header.php'; ?>

<main class="content">
    <div class="container">
        <h1>Mentions légales</h1>
        <p class="muted">Dernière mise à jour: 8 octobre 2025</p>

        <article class="section">
            <h2>Éditeur du site</h2>
            <p>
                DashMed — Site vitrine et application web de suivi de santé.<br>
                Responsable de la publication : Équipe DashMed :<br>
                FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir & UYSUN Ali <br>
                Contact: <a href="mailto:dashmed-site@alwaysdata.net">dashmed-site@alwaysdata.net</a>
            </p>
        </article>

        <article class="section">
            <h2>Hébergement</h2>
            <p>
                Hébergeur: Alwaysdata<br />
                Téléphone: +33 1 84 16 23 40
            </p>
        </article>

        <article class="section">
            <h2>Propriété intellectuelle</h2>
            <p>
                L’ensemble des contenus présents sur le site (textes, graphismes, logos, icônes, images,
                ainsi que leur mise en forme) sont, sauf mention contraire, la propriété exclusive de DashMed.
                Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments
                du site est interdite, sauf autorisation écrite préalable.
            </p>
        </article>

        <article class="section">
            <h2>Données personnelles</h2>
            <p>
                Les informations collectées via nos formulaires (inscription, connexion, mot de passe oublié)
                sont traitées dans le cadre de la fourniture du service. Vous disposez d’un droit d’accès, de rectification,
                d’effacement, de limitation et d’opposition au traitement des données vous concernant.
            </p>
        </article>

        <article class="section">
            <h2>Cookies</h2>
            <p>
                Le site peut déposer des cookies nécessaires au fonctionnement et à la mesure d’audience.
                Vous pouvez configurer votre navigateur pour refuser tout ou partie des cookies.
            </p>
        </article>

        <article class="section">
            <h2>Responsabilité</h2>
            <p>
                Les informations fournies par DashMed sont données à titre indicatif et ne remplacent pas
                l’avis d’un professionnel de santé. DashMed ne saurait être tenue responsable des dommages
                directs ou indirects résultant de l’utilisation du site.
            </p>
        </article>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
