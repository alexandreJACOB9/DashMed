<?php
namespace Controllers;

final class ProfileController
{
    public function show(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $user = $_SESSION['user']; // id, email, name (ou découper si besoin)
        // Si tu as stocké séparément first_name / last_name en session, adapte ici.
        // Exemple découpe simple :
        $parts = preg_split('/\s+/', trim($user['name'] ?? ''), 2);
        $first = $parts[0] ?? '';
        $last  = $parts[1] ?? '';
        require __DIR__ . '/../Views/profile.php';
    }
}