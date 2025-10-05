<?php
namespace Models;

use Core\Database;

final class User
{
    public static function emailExists(string $email): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('SELECT 1 FROM users WHERE email = ? LIMIT 1');
        $st->execute([$email]);
        return (bool)$st->fetchColumn();
    }

    public static function create(string $first, string $last, string $email, string $hash): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare(
            'INSERT INTO users (first_name,last_name,email,password) VALUES (?,?,?,?)'
        );
        return $st->execute([$first,$last,$email,$hash]);
    }
}