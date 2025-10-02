<?php

// Cette classe sert à analyser l’URL pour savoir quel contrôleur et quelle action exécuter.
// Elle vérifie que le contrôleur et l’action existent, puis les lance en leur passant les paramètres de l’URL et du POST.
// Le but de cette classe est donc de centraliser le routage des requêtes dans l’application.
final class Controllers
{
    private $_parsedUrl;
    private $_urlParams;
    private $_postParams;

    public function __construct($url, $postParams)
    {
        //supprime un eventuel "/" à la fin de l'url
        if (substr($url, -1) === '/') {
            $url = substr($url, 0, -1);
        }

        //découpe l'url en segments séparés par des "/"
        $urlParts = explode('/', $url);

        //utilise un contrôleur par défaut si pas spécifié
        if (empty($urlParts[0])) {
            $urlParts[0] = 'DefaultController';
            //Sinon on construit le nom du Contrôleur
        } else {
            $urlParts[0] = 'Controllers' . ucfirst($urlParts[0]);
        }

        //utilise une action par défaut si pas spécifié
        if (empty($urlParts[1])) {
            $urlParts[1] = 'defaultAction';
            //Ajoute Action a la fin pour executer
        } else {
            $urlParts[1] .= 'Action';
        }

        //stock l'action et le contrôleur à executer
        $this->_parsedUrl['controllers'] = array_shift($urlParts);
        $this->_parsedUrl['action'] = array_shift($urlParts);

        //Les paramètres restants de l'url sont considérés comme des arguments
        $this->_urlParams = $urlParts;
        //Stock les paramètres provenant d'un formulaire post
        $this->_postParams = $postParams;
    }

    public function execute()
    {
        //vérifie si le contrôleur existe
        if (!class_exists($this->_parsedUrl['controllers'])) {
            throw new ControllerException($this->_parsedUrl['controllers'] . " is not a valid controller.");
        }

        // vérifie si la méthode (action) existe à l'intérieur du contrôleur
        if (!method_exists($this->_parsedUrl['controllers'], $this->_parsedUrl['action'])) {
            throw new ControllerException("Action " . $this->_parsedUrl['action'] .
                " in controller " . $this->_parsedUrl['controllers'] . " is not valid.");
        }

        //Appel l'action du controleur avec les paramètres GET/POST
        $called = call_user_func_array(
            [new $this->_parsedUrl['controllers'], $this->_parsedUrl['action']],
            [$this->_urlParams, $this->_postParams]
        );

        //SI l'action renvoie FALSE alors erreur d'éxécution
        if ($called === false) {
            throw new ControllerException("Action " . $this->_parsedUrl['action'] .
                " in controller " . $this->_parsedUrl['controllers'] . " failed.");
        }
    }
}
