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

            // Détection : en production (AlwaysData) si domaine contient alwaysdata.net
            $isProd = isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'alwaysdata.net');

            if ($isProd) {
                // REMPLACER les XXXXX ci-dessous par tes valeurs exactes depuis le panel AlwaysData
                $host = 'mysql-dashmed-site.alwaysdata.net';
                $db   = 'dashmed-site_db';               // nom complet de la base
                $user = '433165';                  // utilisateur MySQL
                $pass = 'mCwc99{0~D';            // mot de passe MySQL
            } else {
                // Local
                $host = '127.0.0.1';
                $db   = 'dashmed';
                $user = 'root';
                $pass = '';
            }

            $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                error_log('DB CONNECTION FAIL: '.$e->getMessage());
                throw $e;
            }
        }
        return self::$pdo;
    }
}
