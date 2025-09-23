<?php

class ControllerAuthentication {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($email, $password) {
        try {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Démarrer la session et stocker les informations utilisateur
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                return true;
            }
            return false;
        } catch(PDOException $e) {
            // Log l'erreur et retourner false
            error_log($e->getMessage());
            return false;
        }
    }

    public function register($email, $password, $name) {
        try {
            // Vérifier si l'email existe déjà
            $stmt = $this->db->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return false; // Email déjà utilisé
            }

            // Créer le nouvel utilisateur
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare('INSERT INTO users (email, password, name, created_at) VALUES (?, ?, ?, NOW())');
            return $stmt->execute([$email, $hashedPassword, $name]);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}