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
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

use Controllers\AuthController;
use Controllers\HomeController;
use Controllers\MapController;
use Controllers\LegalNoticesController;
use Controllers\RegistrationController;
use Controllers\ForgottenPasswordController;

// Normalisation du path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/');
if ($path === '') { $path = '/'; }

if ($path === '/health') {
    header('Content-Type: text/plain; charset=utf-8');
    echo 'OK';
    exit;
}

// ------------------------------
// REDIRECTION AUTOMATIQUE POUR CONNECTÉS
// ------------------------------
if (($path === '/' || $path === '/index.php') && !empty($_SESSION['user'])) {
    // Utilisateur connecté → rediriger vers le dashboard
    header('Location: /dashboard');
    exit;
}

// Page d'accueil
if ($path === '/' || $path === '/index.php') {
    (new HomeController())->index();
    exit;
}

// Plan du site
if ($path === '/map') {
    (new MapController())->show();
    exit;
}

// Mentions légales
if ($path === '/legal-notices' || $path === '/mentions-legales') {
    (new LegalNoticesController())->show();
    exit;
}

// Mot de passe oublié
if ($path === '/forgotten-password' || $path === '/mot-de-passe-oublie') {
    $controller = new ForgottenPasswordController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->submit();
    else $controller->showForm();
    exit;
}

// Inscription
if ($path === '/register' || $path === '/inscription') {
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

if ($path === '/dashboard' || $path === '/tableau-de-bord') {
    (new \Controllers\DashboardController())->index();
    exit;
}

if ($path === '/profile' || $path === '/profil') {
    (new \Controllers\ProfileController())->show();
    exit;
}

http_response_code(404);
echo 'Page non trouvée';
