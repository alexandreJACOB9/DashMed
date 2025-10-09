<?php
namespace Controllers;

final class DashboardController {
    public function index(): void {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        require __DIR__ . '/../Views/dashboard.php';
    }
}