<?php
namespace Core;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }

    public static function validate(string $token, int $ttlSeconds = 7200): bool
    {
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            return false;
        }
        if (!empty($_SESSION['csrf_token_time']) && (time() - (int)$_SESSION['csrf_token_time']) > $ttlSeconds) {
            unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
            return false;
        }
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
        return true;
    }
}
