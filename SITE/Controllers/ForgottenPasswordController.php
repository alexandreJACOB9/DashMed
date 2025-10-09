<?php
namespace Controllers;

use Core\Csrf;
use Models\User;

final class ForgottenPasswordController
{
    public function showForm(): void
    {
        $errors = [];
        $success = '';
        $old = ['email' => ''];
        \View::render('forgotten_password', compact('errors', 'success', 'old'));
    }

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
            // On peut vérifier l'existence utilisateur sans révéler l'info
            $user = User::findByEmail($old['email']);
            // Ici on simule toujours un succès pour ne pas divulguer si l'email existe
            $success = 'Si un compte existe, un lien de réinitialisation a été envoyé.';
            $old = ['email' => ''];
        }

        \View::render('forgotten_password', compact('errors', 'success', 'old'));
    }
}
