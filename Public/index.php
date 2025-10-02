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

spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__);
    $file = $baseDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use Controllers\AuthController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

if ($path === '/' || $path === '/inscription' || $path === '/register') {
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();
    } else {
        $controller->showRegister();
    }
    exit;
}

http_response_code(404);
echo 'Page non trouvée';
