<?php
namespace Controllers;

use Models\User;
use Core\Csrf;
use Core\Mailer;

final class AuthController
{
    public function showRegister(): void
    {
        $errors = [];
        $success = '';
        $old = ['name' => '', 'last_name' => '', 'email' => ''];
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register(): void
    {
        $errors = [];
        $success = '';
        $old = [
            'name'      => trim((string)($_POST['name'] ?? '')),
            'last_name' => trim((string)($_POST['last_name'] ?? '')),
            'email'     => trim((string)($_POST['email'] ?? '')),
        ];
        $password         = (string)($_POST['password'] ?? '');
        $password_confirm = (string)($_POST['password_confirm'] ?? '');
        $csrf             = (string)($_POST['csrf_token'] ?? '');

        if (!Csrf::validate($csrf))              $errors[] = 'Session expirée ou jeton CSRF invalide. Veuillez réessayer.';
        if ($old['name'] === '' || mb_strlen($old['name']) < 2)       $errors[] = 'Prénom invalide.';
        if ($old['last_name'] === '' || mb_strlen($old['last_name']) < 2) $errors[] = 'Nom invalide.';
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL))        $errors[] = 'Adresse email invalide.';
        if ($password !== $password_confirm)                          $errors[] = 'Mots de passe différents.';
        if (
            strlen($password) < 12 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password) ||
            !preg_match('/[^A-Za-z0-9]/', $password)
        ) {
            $errors[] = 'Le mot de passe doit contenir au moins 12 caractères, avec majuscules, minuscules, chiffres et un caractère spécial.';
        }

        if (!$errors && User::emailExists($old['email'])) {
            $errors[] = 'Un compte existe déjà avec cette adresse email.';
        }

        if (!$errors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                if (User::create($old['name'], $old['last_name'], $old['email'], $hash )) {
                    //envoie du mail à la création
                    Mailer::sendRegistrationEmail($old['email'], $old['name'], $old['last_name'] ?? '');
                    $success = 'Compte créé. Vous pouvez maintenant vous connecter.';
                    $old = ['name' => '', 'last_name' => '', 'email' => ''];
                } else {
                    $errors[] = 'Insertion échouée.';
                }
            } catch (\Throwable $e) {
                // error_log($e->getMessage());
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
            $user = User::findByEmail($old['email']);
            if (!$user || !password_verify($password, $user['password'])) {
                $errors[] = 'Identifiants invalides.';
            } else {
                // Sécurité évite la fixation de session
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int)$user['user_id'];
                $_SESSION['user_email'] = (string)$user['email'];
                // Concatènation de prénom + nom
                $_SESSION['user_name'] = trim(($user['name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
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
        header('Location: /login');
        exit;
    }
}