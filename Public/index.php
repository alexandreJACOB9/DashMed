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

$siteDir = __DIR__ . '/../SITE';
$autoLoader = $siteDir . '/Core/AutoLoader.php';
if (is_file($autoLoader)) {
    require $autoLoader;
} else {
    spl_autoload_register(function (string $class) use ($siteDir): void {
        $file = $siteDir . '/' . str_replace('\\', '/', $class) . '.php';
        if (is_file($file)) {
            require $file;
        }
    });
}

// Inclure Csrf si besoin (selon ton code actuel)
require_once $siteDir . '/Core/Csrf.php';

// PATCH TEMPORAIRE pour débloquer: on inclut explicitement le contrôleur
require_once $siteDir . '/Controllers/AuthController.php';

use Controllers\AuthController;

// Normalisation du path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/');
if ($path === '') { $path = '/'; }

if ($path === '/health') {
    header('Content-Type: text/plain; charset=utf-8');
    echo 'OK';
    exit;
}

// Inscription
if ($path === '/' || $path === '/inscription' || $path === '/register' || $path === '/index.php') {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->register();
    else $controller->showRegister();
    exit;
}

// Connexion
if ($path === '/login' || $path === '/connexion') {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->login();
    else $controller->showLogin();
    exit;
}

// Déconnexion
if ($path === '/logout' || $path === '/deconnexion') {
    (new AuthController())->logout();
    exit;
}

http_response_code(404);
echo 'Page non trouvée';
