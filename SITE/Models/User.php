<?php

class User {
    private $id;
    private $email;
    private $password;
    private $name;
    private $created_at;

    public function __construct($email, $password, $name) {
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT); // Hashage sécurisé du mot de passe
        $this->name = $name;
        $this->created_at = date('Y-m-d H:i:s');
    }

    // Getters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getName() { return $this->name; }
    public function getCreatedAt() { return $this->created_at; }

    // Méthode de vérification du mot de passe
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
}