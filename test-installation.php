<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='utf-8'>
    <title>Test Installation DashMed</title>
    <style>
        body{font-family:system-ui;padding:20px;background:#f4f6f8}
        .test{background:white;padding:15px;margin:10px 0;border-radius:8px;border-left:4px solid #ccc}
        .ok{border-left-color:#22c55e}
        .error{border-left-color:#ef4444}
        .warning{border-left-color:#f59e0b}
        h1{color:#1a1a1a}
        h2{color:#374151;font-size:18px;margin-top:30px}
        code{background:#e5e7eb;padding:2px 6px;border-radius:4px;font-size:13px}
    </style>
</head>
<body>
<h1>🔍 Test d'installation DashMed</h1>";

// Test 1 : Version PHP
echo "<h2>1. Environnement PHP</h2>";
$phpVersion = PHP_VERSION;
$phpOk = version_compare($phpVersion, '7.4.0', '>=');
echo "<div class='test " . ($phpOk ? 'ok' : 'error') . "'>";
echo "Version PHP : <code>$phpVersion</code> " . ($phpOk ? '✅' : '❌ (minimum 7.4 requis)');
echo "</div>";

// Test 2 : Extensions PHP
echo "<h2>2. Extensions PHP</h2>";
$extensions = ['pdo', 'pdo_mysql', 'pdo_sqlite', 'session', 'json'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "<div class='test " . ($loaded ? 'ok' : 'warning') . "'>";
    echo "Extension <code>$ext</code> : " . ($loaded ? '✅ Chargée' : '⚠️ Non chargée');
    echo "</div>";
}

// Test 3 : Structure des dossiers
echo "<h2>3. Structure des dossiers</h2>";
$dirs = [
    'SITE' => __DIR__ . '/SITE',
    'SITE/Core' => __DIR__ . '/SITE/Core',
    'SITE/Controllers' => __DIR__ . '/SITE/Controllers',
    'SITE/Models' => __DIR__ . '/SITE/Models',
    'SITE/Views' => __DIR__ . '/SITE/Views',
    'Public' => __DIR__ . '/Public',
    'Public/assets' => __DIR__ . '/Public/assets',
];

foreach ($dirs as $name => $path) {
    $exists = is_dir($path);
    echo "<div class='test " . ($exists ? 'ok' : 'error') . "'>";
    echo "Dossier <code>$name</code> : " . ($exists ? '✅ Existe' : '❌ Manquant');
    echo "</div>";
}

// Test 4 : Fichiers critiques
echo "<h2>4. Fichiers critiques</h2>";
$files = [
    'Public/index.php' => __DIR__ . '/Public/index.php',
    'SITE/Core/Database.php' => __DIR__ . '/SITE/Core/Database.php',
    'SITE/Core/SITE_Core_Csrf.php' => __DIR__ . '/SITE/Core/SITE_Core_Csrf.php',
    'SITE/Controllers/AuthController.php' => __DIR__ . '/SITE/Controllers/AuthController.php',
    'SITE/Models/User.php' => __DIR__ . '/SITE/Models/User.php',
];

foreach ($files as $name => $path) {
    $exists = is_file($path);
    echo "<div class='test " . ($exists ? 'ok' : 'error') . "'>";
    echo "Fichier <code>$name</code> : " . ($exists ? '✅ Existe' : '❌ Manquant');
    echo "</div>";
}

// Test 5 : Base de données
echo "<h2>5. Connexion à la base de données</h2>";
try {
    require_once __DIR__ . '/SITE/Core/Database.php';
    $pdo = \Core\Database::getConnection();

    echo "<div class='test ok'>";
    echo "Connexion à la base : ✅ Réussie<br>";
    echo "Driver : <code>" . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "</code>";
    echo "</div>";

    // Vérifier la table users
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        $count = $stmt->fetchColumn();
        echo "<div class='test ok'>";
        echo "Table <code>users</code> : ✅ Existe ($count utilisateurs)";
        echo "</div>";
    } catch (Exception $e) {
        echo "<div class='test warning'>";
        echo "Table <code>users</code> : ⚠️ N'existe pas encore<br>";
        echo "➡️ Exécutez <code>Public/install-sqlite.php</code> pour créer la table";
        echo "</div>";
    }

} catch (Exception $e) {
    echo "<div class='test error'>";
    echo "Connexion à la base : ❌ Échec<br>";
    echo "Erreur : <code>" . htmlspecialchars($e->getMessage()) . "</code>";
    echo "</div>";
}

// Test 6 : Sessions
echo "<h2>6. Sessions PHP</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sessionOk = (session_status() === PHP_SESSION_ACTIVE);
echo "<div class='test " . ($sessionOk ? 'ok' : 'error') . "'>";
echo "Sessions : " . ($sessionOk ? '✅ Fonctionnelles' : '❌ Non fonctionnelles');
echo "</div>";

// Test 7 : Permissions
echo "<h2>7. Permissions des fichiers</h2>";
$writable = is_writable(__DIR__ . '/SITE/Core');
echo "<div class='test " . ($writable ? 'ok' : 'warning') . "'>";
echo "Dossier <code>SITE/Core</code> : " . ($writable ? '✅ Accessible en écriture' : '⚠️ Non accessible en écriture (nécessaire pour SQLite)');
echo "</div>";

// Résumé
echo "<h2>📋 Résumé</h2>";
echo "<div class='test'>";
echo "<strong>Actions recommandées :</strong><br><br>";
echo "1️⃣ Si la table <code>users</code> n'existe pas, créez-la avec : <code>http://votre-site/install-sqlite.php</code><br>";
echo "2️⃣ Configurez votre serveur web pour pointer vers le dossier <code>Public/</code><br>";
echo "3️⃣ Si vous utilisez Apache, assurez-vous que <code>mod_rewrite</code> est activé<br>";
echo "4️⃣ Testez l'inscription : <code>http://votre-site/inscription</code><br>";
echo "5️⃣ Testez la connexion : <code>http://votre-site/login</code>";
echo "</div>";

echo "</body></html>";
