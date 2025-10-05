<?php
namespace Controllers;

use Models\User;
use Core\Csrf;

final class AuthController
{
    public function showRegister(): void
    {
        $errors = [];
        $success = '';
        $old = ['name'=>'','last_name'=>'','email'=>''];
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register(): void
    {
        $errors = [];
        $success = '';
        $old = [
            'name' => trim((string)($_POST['name'] ?? '')),
            'last_name'  => trim((string)($_POST['last_name'] ?? '')),
            'email'      => trim((string)($_POST['email'] ?? '')),
        ];
        $password         = (string)($_POST['password'] ?? '');
        $password_confirm = (string)($_POST['password_confirm'] ?? '');
        $csrf             = $_POST['csrf_token'] ?? '';

        if (!Csrf::validate($csrf)) $errors[] = 'CSRF invalide.';
        if ($old['name'] === '' || mb_strlen($old['name']) < 2) $errors[] = 'Prénom invalide.';
        if ($old['last_name'] === '' || mb_strlen($old['last_name']) < 2)   $errors[] = 'Nom invalide.';
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL))             $errors[] = 'Email invalide.';
        if ($password !== $password_confirm)                               $errors[] = 'Mots de passe différents.';
        if (
            strlen($password) < 12 ||
            !preg_match('/[A-Z]/',$password) ||
            !preg_match('/[a-z]/',$password) ||
            !preg_match('/\d/',$password) ||
            !preg_match('/[^A-Za-z0-9]/',$password)
        ) $errors[] = 'Mot de passe trop faible.';

        if (!$errors && User::emailExists($old['email'])) {
            $errors[] = 'Email déjà utilisé.';
        }

        if (!$errors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                if (User::create($old['name'],$old['last_name'],$old['email'],$hash)) {
                    $success = 'Compte créé.';
                    $old = ['name'=>'','last_name'=>'','email'=>''];
                } else {
                    $errors[] = 'Insertion échouée.';
                }
            } catch (\Throwable) {
                $errors[] = 'Erreur base.';
            }
        }

        require __DIR__ . '/../Views/auth/register.php';
    }

    public function showLogin(): void
    {
        $errors = [];
        $success = '';
        $old = ['email' => ''];
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login(): void
    {
        $errors = [];
        $success = '';
        $old = [
            'email' => trim((string)($_POST['email'] ?? '')),
        ];
        $password = (string)($_POST['password'] ?? '');
        $csrf = (string)($_POST['csrf_token'] ?? '');

        if (!Csrf::validate($csrf)) {
            $errors[] = 'Session expirée ou jeton CSRF invalide. Veuillez réessayer.';
        }

        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Adresse email invalide.';
        }
        if ($password === '') {
            $errors[] = 'Le mot de passe est obligatoire.';
        }

        if (!$errors) {
            $user = User::findByEmail($old['email'] ?? '');
            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors[] = 'Identifiants invalides.';
            } else {
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_name'] = (string)$user['name'];
                header('Location: /');
                exit;
            }
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        header('Location: /');
        exit;
    }
}
