<?php
namespace Controllers;

use Core\Csrf;
use Models\User;

final class AuthController
{
    public function showRegister(): void
    {
        $errors = [];
        $success = '';
        $old = ['name' => '', 'email' => ''];

        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register(): void
    {
        $errors = [];
        $success = '';
        $old = [
            'name' => trim((string)($_POST['name'] ?? '')),
            'email' => trim((string)($_POST['email'] ?? '')),
        ];
        $password = (string)($_POST['password'] ?? '');
        $password_confirm = (string)($_POST['password_confirm'] ?? '');
        $csrf = (string)($_POST['csrf_token'] ?? '');

        if (!Csrf::validate($csrf)) {
            $errors[] = 'Session expirée ou jeton CSRF invalide. Veuillez réessayer.';
        }

        if ($old['name'] === '') {
            $errors[] = 'Le nom est obligatoire.';
        }
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Adresse email invalide.';
        }
        if (
            strlen($password) < 12 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password)
        ) {
            $errors[] = 'Le mot de passe doit contenir au moins 12 caractères, avec majuscules, minuscules et chiffres.';
        }
        if ($password !== $password_confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if (!$errors && User::emailExists($old['email'])) {
            $errors[] = 'Un compte existe déjà avec cette adresse email.';
        }

        if (!$errors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                User::create($old['name'], $old['email'], $hash);
                $success = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
                $old = ['name' => '', 'email' => ''];
            } catch (\Throwable $e) {
                $errors[] = 'Erreur lors de la création du compte.';
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
        $old = ['email' => trim((string)($_POST['email'] ?? ''))];
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
            $valid = $user && password_verify($password, $user['password_hash'] ?? '');

            if ($valid) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_name'] = (string)$user['name'];
                $_SESSION['user_email'] = (string)$user['email'];

                header('Location: /');
                exit;
            } else {
                $errors[] = 'Identifiants invalides.';
            }
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();

        header('Location: /login');
        exit;
    }
}
