<?php
namespace Core;
use PDO, PDOException;

final class Database {
    private static ?PDO $pdo=null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            $path = self::loadEnv();

            var_dump($path);
            
            $driver = trim(getenv('DB_DRIVER') ?: 'mysql');
            $host   = trim(getenv('DB_HOST')   ?: '127.0.0.1');
            $port   = trim(getenv('DB_PORT')   ?: '3306');
            $db     = trim(getenv('DB_NAME')   ?: 'dashmed');
            $user   = trim(getenv('DB_USER')   ?: 'root');
            $pass   = (getenv('DB_PASS') !== false) ? getenv('DB_PASS') : '';

            $dsn = "$driver:host=$host;port=$port;dbname=$db;charset=utf8mb4";
            // LOG TEMP
            error_log('DB_DEBUG '.json_encode([
                'dsn'=>$dsn,
                'user'=>$user,
                'host_hex'=>bin2hex($host),
            ]));

            try {
                self::$pdo = new PDO($dsn,$user,$pass,[
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES=>false,
                ]);
            } catch (PDOException $e) {
                throw $e;
            }
        }
        return self::$pdo;
    }

    private static function loadEnv(): void {
        $path = dirname(__DIR__,2).'/.env';
        if (!is_file($path)) return;
        foreach (file($path, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES) as $line) {
            if ($line[0]==='#' || !str_contains($line,'=')) continue;
            [$k,$v]=array_map('trim',explode('=',$line,2));
            if ($k!=='' && getenv($k)===false) putenv("$k=$v");
        }

        return $path;
    }
}