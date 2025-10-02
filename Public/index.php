<?php
declare(strict_types=1);

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_name('dashmed_session');
session_start();

// Autoload
spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . '/SITE';
    $file = $baseDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require_once dirname(__DIR__) . '/SITE/Core/SITE_Core_Csrf.php';

use Controllers\AuthController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

// Page d'accueil (index.html)
if ($path === '/' || $path === '/index' || $path === '/accueil') {
    if (isset($_SESSION['user_id'])) {
        // Si connecté, afficher le dashboard
        echo "Dashboard - Bienvenue " . htmlspecialchars($_SESSION['user_name'] ?? '', ENT_QUOTES, 'UTF-8');
    } else {
        // Sinon afficher la page d'accueil statique
        require __DIR__ . '/../SITE/Views/index.html';
    }
    exit;
}

// Inscription
if ($path === '/inscription' || $path === '/register') {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();
    } else {
        $controller->showRegister();
    }
    exit;
}

// Connexion
if ($path === '/login' || $path === '/connexion' || $path === '/authentication') {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
    } else {
        $controller->showLogin();
    }
    exit;
}

// Déconnexion
if ($path === '/logout' || $path === '/deconnexion') {
    $controller = new AuthController();
    $controller->logout();
    exit;
}

// Plan du site
if ($path === '/map' || $path === '/plan-du-site') {
    require __DIR__ . '/../SITE/Views/map.html';
    exit;
}

// Mentions légales
if ($path === '/legal-notices' || $path === '/mentions-legales') {
    require __DIR__ . '/../SITE/Views/legal_notices.html';
    exit;
}

// Mot de passe oublié
if ($path === '/forgotten-password' || $path === '/mot-de-passe-oublie') {
    require __DIR__ . '/../SITE/Views/forgotten_password.html';
    exit;
}

// Servir les fichiers statiques (CSS, JS, images)
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg)$/', $path)) {
    $file = __DIR__ . $path;
    if (file_exists($file)) {
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml',
        ];
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        header('Content-Type: ' . ($mimeTypes[$ext] ?? 'application/octet-stream'));
        readfile($file);
        exit;
    }
}

// 404 par défaut
http_response_code(404);
echo '<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>404 - Page non trouvée</title>
    <style>
        body{font-family:system-ui;margin:0;padding:48px;text-align:center;background:#f4f6f8}
        h1{color:#1a1a1a;font-size:48px;margin:0 0 16px}
        p{color:#6b6f76;margin:0 0 24px}
        a{color:#12C9D4;text-decoration:none}
        a:hover{text-decoration:underline}
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Page non trouvée</p>
    <a href="/">Retour à l\'accueil</a>
</body>
</html>';