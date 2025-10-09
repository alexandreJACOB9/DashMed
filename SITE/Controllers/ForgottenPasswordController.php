<?php
namespace Controllers;

use Core\Csrf;
use Core\Database;
use Core\Mailer;
use Models\User;
use PDO;

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
            try {
                // Vérifie si l'email est inscrit
                $user = User::findByEmail($old['email']);
                if ($user) {
                    $pdo = Database::getConnection();

                    // Nettoyage des anciens tokens pour le mail associer au mdp réunitialiser
                    $del = $pdo->prepare('DELETE FROM password_resets WHERE email = ? OR expires_at < NOW()');
                    $del->execute([$old['email']]);

                    // Génère un nouveau token
                    $token = bin2hex(random_bytes(32));
                    $tokenHash = hash('sha256', $token);
                    $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 60 minutes

                    $ins = $pdo->prepare(
                        'INSERT INTO password_resets (email, token_hash, expires_at) VALUES (?, ?, ?)'
                    );
                    $ins->execute([$old['email'], $tokenHash, $expiresAt]);

                    // Construit l'URL reset
                    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
                    $resetUrl = $scheme . '://' . $host . '/reset-password?token=' . urlencode($token) . '&email=' . urlencode($old['email']);

                    // Nom d’affichage
                    $displayName = trim(($user['name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
                    Mailer::sendPasswordResetEmail($old['email'], $displayName ?: 'Utilisateur', $resetUrl);
                }

                // Réponse neutre
                $success = 'Si un compte existe, un lien de réinitialisation a été envoyé.';
                $old = ['email' => ''];
            } catch (\Throwable $e) {
                error_log(sprintf('[FORGOT] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
                $success = 'Si un compte existe, un lien de réinitialisation a été envoyé.';
                $old = ['email' => ''];
            }
        }

        \View::render('forgotten_password', compact('errors', 'success', 'old'));
    }
}