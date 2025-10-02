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

// Autoload: pointer vers le dossier /SITE pour retrouver Controllers/, Models/, Core/
spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . '/SITE';
    $file = $baseDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

// La classe CSRF est dans un fichier nommé différemment: on l'inclut explicitement
require_once dirname(__DIR__) . '/SITE/Core/SITE_Core_Csrf.php';

use Controllers\AuthController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

// Inscription (par défaut sur /)
if ($path === '/' || $path === '/inscription' || $path === '/register') {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();
    } else {
        $controller->showRegister();
    }
    exit;
}

// Connexion
if ($path === '/login' || $path === '/connexion') {
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

// 404 par défaut
http_response_code(404);
echo 'Page non trouvée';
