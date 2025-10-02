<?php
declare(strict_types=1);

require_once __DIR__ . '/../SITE/Core/Database.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $pdo = \Core\Database::getConnection();

    // Active les FK en SQLite
    if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
        $pdo->exec('PRAGMA foreign_keys = ON;');
    }

    // Création table users (SQLite)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            created_at TEXT NOT NULL,
            updated_at TEXT NOT NULL
        );
    ");
    $pdo->exec("CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);");

    echo 'OK: base SQLite prête.';
} catch (Throwable $e) {
    http_response_code(500);
    echo 'ERREUR: ' . $e->getMessage();
}
