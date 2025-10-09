<?php
namespace Controllers;

use Core\Csrf;
use Core\Database;

final class ResetPasswordController
{
    public function showForm(): void
    {
        $errors = [];
        $success = '';

        // Normaliser l'email
        $email = strtolower(trim((string)($_GET['email'] ?? '')));
        $token = (string)($_GET['token'] ?? '');

        if (!$this->isValidToken($email, $token)) {
            $errors[] = 'Lien de réinitialisation invalide ou expiré.';
        }

        \View::render('reset_password', compact('errors', 'success', 'email', 'token'));
    }

    public function submit(): void
    {
        $errors = [];
        $success = '';

        $csrf     = (string)($_POST['csrf_token'] ?? '');
        $email    = strtolower(trim((string)($_POST['email'] ?? '')));
        $token    = (string)($_POST['token'] ?? '');
        $password = (string)($_POST['password'] ?? '');
        $confirm  = (string)($_POST['password_confirm'] ?? '');

        if (!Csrf::validate($csrf))                            $errors[] = 'Session expirée ou jeton CSRF invalide.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))        $errors[] = 'Adresse email invalide.';
        if ($password !== $confirm)                            $errors[] = 'Mots de passe différents.';
        if (
            strlen($password) < 12 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password) ||
            !preg_match('/[^A-Za-z0-9]/', $password)
        ) {
            $errors[] = 'Mot de passe trop faible (12+ car., maj/min/chiffre/spécial).';
        }

        if (!$errors && !$this->isValidToken($email, $token)) {
            $errors[] = 'Lien de réinitialisation invalide ou expiré.';
        }

        if (!$errors) {
            $pdo = Database::getConnection();
            $tokenHash = hash('sha256', $token);

            try {
                $pdo->beginTransaction();

                // Met à jour le mot de passe utilisateur (insensible à la casse)
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $u = $pdo->prepare('UPDATE users SET password = ?, updated_at = NOW() WHERE LOWER(email) = LOWER(?)');
                $u->execute([$hash, $email]);
                $updated = $u->rowCount();

                if ($updated > 0) {
                    // Invalide le token seulement si update OK
                    $t = $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE LOWER(email) = LOWER(?) AND token_hash = ? AND used_at IS NULL');
                    $t->execute([$email, $tokenHash]);

                    $pdo->commit();
                    $success = 'Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.';
                } else {
                    // Aucune ligne modifiée -> email non trouvé tel qu’envoyé
                    $pdo->rollBack();
                    error_log(sprintf('[RESET] No user row updated for email=%s', $email));
                    $errors[] = 'Une erreur technique est survenue lors de la réinitialisation. Veuillez réessayer.';
                }
            } catch (\Throwable $e) {
                $pdo->rollBack();
                error_log(sprintf('[RESET] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
                $errors[] = 'Erreur base.';
            }
        }

        \View::render('reset_password', compact('errors', 'success', 'email', 'token'));
    }

    private function isValidToken(string $email, string $token): bool
    {
        if ($email === '' || $token === '') return false;

        $pdo = Database::getConnection();
        $tokenHash = hash('sha256', $token);

        // Vérif  token insensible à la casse sur l'email
        $st = $pdo->prepare('
            SELECT 1
            FROM password_resets
            WHERE LOWER(email) = LOWER(?)
              AND token_hash = ?
              AND used_at IS NULL
              AND expires_at > NOW()
            LIMIT 1
        ');
        $st->execute([$email, $tokenHash]);

        return (bool) $st->fetchColumn();
    }
}
