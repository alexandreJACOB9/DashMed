<?php

//Cette classe gère les erreurs liées aux contrôleurs
//Elle renvoie le nom du Contrôleur et de l'action concernés ce qui facilite le debug
class ControllerException extends Exception
{
    private $controller; // Nom du contrôleur où l'erreur est survenue
    private $action;  // Nom de l'action qui a provoqué l'erreur

    //initialise le message d'erreur et les informations sur le contrôleur ainsi que sur l'action
    public function __construct($message, $controller = null, $action = null)
    {
        parent::__construct($message);
        $this->controller = $controller;
        $this->action = $action;
    }
    //retourne le nom du Contrôleurs où il y a l'erreur
    public function getController()
    {
        return $this->controller;
    }
    //retourne le nom de l'action où il ya l'erreur
    public function getAction()
    {
        return $this->action;
    }
}
?>