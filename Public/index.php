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

$siteDir = dirname(__DIR__);
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

// La classe CSRF est dans un fichier nommé différemment: on l'inclut explicitement
require_once dirname(__DIR__) . '/SITE/Core/Csrf.php';

use Controllers\AuthController;

// Récupère le chemin et normalise (supprime la barre finale sauf pour la racine)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/');
if ($path === '') {
    $path = '/';
}

// Route santé (debug): utile pour valider que le docroot et la réécriture fonctionnent
if ($path === '/health') {
    header('Content-Type: text/plain; charset=utf-8');
    echo 'OK';
    exit;
}

// Inscription (par défaut sur /). Gère aussi /index.php
if ($path === '/' || $path === '/inscription' || $path === '/register' || $path === '/index.php') {
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


