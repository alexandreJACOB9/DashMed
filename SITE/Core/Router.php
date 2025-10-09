<?php
namespace Core;

use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\ForgottenPasswordController;
use Controllers\HomeController;
use Controllers\LegalNoticesController;
use Controllers\MapController;
use Controllers\ProfileController;
use Controllers\ResetPasswordController;

final class Router
{
    private string $path;
    private string $method;

    public function __construct(string $uri, string $method)
    {
        $this->path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $this->path = rtrim($this->path, '/');
        if ($this->path === '') {
            $this->path = '/';
        }
        $this->method = strtoupper($method);
    }

    public function dispatch(): void
    {
        // Health check
        if ($this->path === '/health') {
            header('Content-Type: text/plain; charset=utf-8');
            echo 'OK';
            exit;
        }

        // Redirection automatique si connecté sur la page d'accueil
        if (($this->path === '/' || $this->path === '/index.php') && !empty($_SESSION['user'])) {
            header('Location: /dashboard');
            exit;
        }

        // Routes publiques
        $this->handlePublicRoutes();

        // Routes d'authentification
        $this->handleAuthRoutes();

        // Routes protégées
        $this->handleProtectedRoutes();

        // 404 - Page non trouvée
        http_response_code(404);
        echo 'Page non trouvée';
    }

    private function handlePublicRoutes(): void
    {
        // Accueil
        if ($this->path === '/' || $this->path === '/index.php') {
            (new HomeController())->index();
            exit;
        }

        // Plan du site
        if ($this->path === '/map') {
            (new MapController())->show();
            exit;
        }

        // Mentions légales
        if ($this->path === '/legal-notices' || $this->path === '/mentions-legales') {
            (new LegalNoticesController())->show();
            exit;
        }

        // Réinitialisation du mot de passe (page avec formulaire de nouveau mot de passe)
        if ($this->path === '/reset-password') {
            $controller = new ResetPasswordController();
            if ($this->method === 'POST') {
                $controller->submit();
            } else {
                $controller->showForm();
            }
            exit;
        }
    }

    private function handleAuthRoutes(): void
    {
        // Inscription
        if ($this->path === '/register' || $this->path === '/inscription') {
            $controller = new AuthController();
            if ($this->method === 'POST') {
                $controller->register();
            } else {
                $controller->showRegister();
            }
            exit;
        }

        // Connexion
        if ($this->path === '/login' || $this->path === '/connexion') {
            $controller = new AuthController();
            if ($this->method === 'POST') {
                $controller->login();
            } else {
                $controller->showLogin();
            }
            exit;
        }

        // Déconnexion
        if ($this->path === '/logout' || $this->path === '/deconnexion') {
            (new AuthController())->logout();
            exit;
        }

        // Mot de passe oublié
        if ($this->path === '/forgotten-password' || $this->path === '/mot-de-passe-oublie') {
            $controller = new ForgottenPasswordController();
            if ($this->method === 'POST') {
                $controller->submit();
            } else {
                $controller->showForm();
            }
            exit;
        }
    }

    private function handleProtectedRoutes(): void
    {
        // Dashboard
        if ($this->path === '/dashboard' || $this->path === '/tableau-de-bord') {
            (new DashboardController())->index();
            exit;
        }

        // Profil
        if ($this->path === '/profile' || $this->path === '/profil') {
            (new ProfileController())->show();
            exit;
        }
    }
}