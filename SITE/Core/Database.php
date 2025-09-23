<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            // À modifier selon vos paramètres
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=dashmed;charset=utf8',
                'root',
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch(PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}