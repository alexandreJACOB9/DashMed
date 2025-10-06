<?php
namespace Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            self::loadEnv();

            $driver = getenv('DB_DRIVER') ?: 'mysql';
            $host   = getenv('DB_HOST') ?: '127.0.0.1';
            $port   = getenv('DB_PORT') ?: '3306';
            $db     = getenv('DB_NAME') ?: 'dashmed';
            $user   = getenv('DB_USER') ?: 'root';
            $pass   = getenv('DB_PASS') ?: '';

            $dsn = "$driver:host=$host;port=$port;dbname=$db;charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                error_log("DB FAIL ($dsn): ".$e->getMessage());
                throw $e;
            }
        }
        return self::$pdo;
    }

    private static function loadEnv(): void
    {
        $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env';
        if (!is_file($path)) return;

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if ($line[0] === '#' || !str_contains($line, '=')) continue;
            [$k,$v] = array_map('trim', explode('=', $line, 2));
            if ($k !== '' && getenv($k) === false) {
                putenv("$k=$v");
            }
        }
    }
}