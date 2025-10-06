<?php
declare(strict_types=1);

require __DIR__ . '/../SITE/Core/AutoLoader.php';

use Core\Database;

header('Content-Type: text/plain; charset=utf-8');

try {
    $pdo = Database::getConnection();
    echo "Connexion OK\n";
    echo "Version serveur: " . $pdo->query('SELECT VERSION()')->fetchColumn() . "\n";
    echo "Test requête: " . $pdo->query('SELECT 1')->fetchColumn() . "\n";
} catch (Throwable $e) {
    http_response_code(500);
    echo "ERREUR: " . $e->getMessage();
}