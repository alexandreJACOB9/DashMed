<?php
namespace Controllers;

use Core\Csrf;
use Core\Mailer;
use Models\User;

final class ForgottenPasswordController
{
    /**
     * Affiche le formulaire de demande de réinitialisation
     */
    public function showForm(): void
    {
        $errors = [];
        $success = '';
        $old = ['email' => ''];
        \View::render('forgotten_password', compact('errors', 'success', 'old'));
    }

    /**
     * Traite la demande de réinitialisation
     */
    public function submit(): void
    {
        $errors = [];
        $success = '';
        $old = [
            'email' => trim((string)($_POST['email'] ?? '')),
        ];
        $csrf = (string)($_POST['csrf_token'] ?? '');

        if (!Csrf::validate($csrf)) {
            $errors[] = 'Session expirée ou jeton CSRF invalide.';
        }

        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Adresse email invalide.';
        }

        if (!$errors) {
            // Créer un token de réinitialisation
            $token = User::createPasswordResetToken($old['email']);

            if ($token) {
                // Envoyer l'email avec le lien de réinitialisation
                $resetLink = 'https://' . $_SERVER['HTTP_HOST'] . '/reset-password?token=' . urlencode($token);

                $emailSent = Mailer::sendPasswordResetEmail($old['email'], $resetLink);

                if ($emailSent) {
                    $success = 'Un email contenant les instructions de réinitialisation a été envoyé à votre adresse.';
                } else {
                    $success = 'Si un compte existe avec cet email, vous recevrez un lien de réinitialisation.';
                }
            } else {
                // Ne pas révéler si l'email existe ou non (sécurité)
                $success = 'Si un compte existe avec cet email, vous recevrez un lien de réinitialisation.';
            }

            $old = ['email' => ''];
        }

        \View::render('forgotten_password', compact('errors', 'success', 'old'));
    }

    /**
     * Affiche le formulaire de réinitialisation avec token
     */
    public function showResetForm(): void
    {
        $token = (string)($_GET['token'] ?? '');

        if ($token === '') {
            header('Location: /forgotten-password');
            exit;
        }

        // Vérifier la validité du token
        $user = User::findByResetToken($token);

        if (!$user) {
            $errors = ['Le lien de réinitialisation est invalide ou a expiré.'];
            $success = '';
            $old = ['email' => ''];
            \View::render('forgotten_password', compact('errors', 'success', 'old'));
            return;
        }

        $errors = [];
        $success = '';

        require __DIR__ . '/../Views/reset_password.php';
    }

    /**
     * Traite la réinitialisation du mot de passe
     */
    public function resetPassword(): void
    {
        $errors = [];
        $token = (string)($_POST['token'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $passwordConfirm = (string)($_POST['password_confirm'] ?? '');
        $csrf = (string)($_POST['csrf_token'] ?? '');

        if (!Csrf::validate($csrf)) {
            $errors[] = 'Session expirée ou jeton CSRF invalide.';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        // Validation du mot de passe
        if (
            strlen($password) < 12 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password) ||
            !preg_match('/[^A-Za-z0-9]/', $password)
        ) {
            $errors[] = 'Le mot de passe doit contenir au moins 12 caractères, avec majuscules, minuscules, chiffres et un caractère spécial.';
        }

        // Vérifier le token
        $user = User::findByResetToken($token);

        if (!$user) {
            $errors[] = 'Le lien de réinitialisation est invalide ou a expiré.';
        }

        if (!$errors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            if (User::updatePassword((int)$user['user_id'], $hash)) {
                // Supprimer le token
                User::clearResetToken((int)$user['user_id']);

                // Rediriger vers la connexion avec message
                $_SESSION['reset_success'] = 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.';
                header('Location: /login');
                exit;
            } else {
                $errors[] = 'Erreur lors de la réinitialisation du mot de passe.';
            }
        }

        $success = '';
        require __DIR__ . '/../Views/reset_password.php';
    }
}