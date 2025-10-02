<?php
/**
 * Script pour corriger automatiquement les liens dans les fichiers HTML
 * À exécuter une seule fois pour mettre à jour tous les fichiers
 */

$replacements = [
    // Liens de navigation
    'href="index.html"' => 'href="/"',
    'href="registration.html"' => 'href="/inscription"',
    'href="authentication.html"' => 'href="/login"',
    'href="map.html"' => 'href="/map"',
    'href="legal_notices.html"' => 'href="/legal-notices"',
    'href="forgotten_password.html"' => 'href="/forgotten-password"',
    'href="accueil.html"' => 'href="/"',
    'href="login.html"' => 'href="/login"',
    'href="reset.html"' => 'href="/forgotten-password"',
    'href="mentions-legales.html"' => 'href="/legal-notices"',
    'href="plan-du-site.html"' => 'href="/map"',

    // Chemins CSS (depuis SITE/Views/)
    'href="../../Public/assets/style/' => 'href="/assets/style/',
    'href="../Public/assets/style/' => 'href="/assets/style/',

    // Chemins images (depuis SITE/Views/)
    'src="../../Public/assets/images/' => 'src="/assets/images/',
    'src="../Public/assets/images/' => 'src="/assets/images/',
    'src="../../../DashMed/SITE/Public/assets/images/' => 'src="/assets/images/',

    // Chemins JS
    'src="../../Public/assets/js/' => 'src="/assets/js/',
    'src="../Public/assets/js/' => 'src="/assets/js/',

    // Favicons
    'href="../../Public/assets/images/icons/favicon.ico"' => 'href="/assets/images/icons/favicon.ico"',
    'href="../Public/assets/images/icons/favicon.ico"' => 'href="/assets/images/icons/favicon.ico"',
];

$files = [
    __DIR__ . '/SITE/Views/index.html',
    __DIR__ . '/SITE/Views/map.html',
    __DIR__ . '/SITE/Views/legal_notices.html',
    __DIR__ . '/SITE/Views/forgotten_password.html',
    __DIR__ . '/SITE/Views/authentication.html',
    __DIR__ . '/SITE/Views/registration.html',
];

echo "🔧 Correction des liens dans les fichiers HTML...\n\n";

foreach ($files as $file) {
    if (!file_exists($file)) {
        echo "⚠️  Fichier non trouvé : $file\n";
        continue;
    }

    $content = file_get_contents($file);
    $original = $content;

    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }

    if ($content !== $original) {
        file_put_contents($file, $content);
        echo "✅ Corrigé : " . basename($file) . "\n";
    } else {
        echo "ℹ️  Pas de changement : " . basename($file) . "\n";
    }
}

echo "\n✨ Terminé !\n";
echo "\n💡 Prochaines étapes :\n";
echo "1. Accédez à http://localhost:8000/test-installation.php\n";
echo "2. Si tout est OK, accédez à http://localhost:8000/install-sqlite.php\n";
echo "3. Testez l'inscription sur http://localhost:8000/inscription\n";
?>
