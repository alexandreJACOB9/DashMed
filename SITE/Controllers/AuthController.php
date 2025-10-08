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
                if (User::create($old['name'], $old['email'], $hash)) {
                    // Envoi de mail (ne bloque pas si échec normalement...)
                    $mailSent = Mailer::sendRegistrationEmail($old['email'], $old['name']);
                    $success = $mailSent
                        ? 'Compte créé !!! Un email de confirmation a été envoyé'
                        : 'Compte créé. (Attention: le mail de bienvenue n’a pas pu être envoyé.)';
                    $old = ['name' => '', 'email' => ''];
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
         if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $errors = [];
    $success = '';
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $csrf = (string)($_POST['csrf_token'] ?? '');
    $old = ['email' => $email];

    if (!Csrf::validate($csrf)) {
        $errors[] = 'Session expirée ou jeton CSRF invalide. Veuillez réessayer.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Adresse email invalide.';
    }
    if ($email === '' || $password === '') {
        $errors[] = 'Champs requis.';
    }

    if (!$errors) {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Identifiants invalides.';
        } else {
            session_regenerate_id(true);
            // Normalise le nom (prend name ou first_name)
            $first = $user['name'] ?? ($user['first_name'] ?? '');
            $last  = $user['last_name'] ?? '';
            $_SESSION['user'] = [
                'id'    => (int)$user['user_id'],
                'email' => $user['email'],
                'name'  => trim($first.' '.$last)
            ];
            $_SESSION['user_id']    = (int)$user['user_id'];   // (optionnel si déjà dans user)
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name']  = trim($first.' '.$last);
            header('Location: /dashboard');
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