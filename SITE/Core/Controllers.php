<?php

final class Controllers
{
    private $_parsedUrl;
    private $_urlParams;
    private $_postParams;

    public function __construct($url, $postParams)
    {
        if (substr($url, -1) === '/') {
            $url = substr($url, 0, -1);
        }

        $urlParts = explode('/', $url);

        if (empty($urlParts[0])) {
            $urlParts[0] = 'DefaultController';
        } else {
            $urlParts[0] = 'Controllers' . ucfirst($urlParts[0]);
        }

        if (empty($urlParts[1])) {
            $urlParts[1] = 'defaultAction';
        } else {
            $urlParts[1] .= 'Action';
        }

        $this->_parsedUrl['controllers'] = array_shift($urlParts);
        $this->_parsedUrl['action'] = array_shift($urlParts);

        $this->_urlParams = $urlParts;
        $this->_postParams = $postParams;
    }

    public function execute()
    {
        if (!class_exists($this->_parsedUrl['controllers'])) {
            throw new ControllerException($this->_parsedUrl['controllers'] . " is not a valid controller.");
        }

        if (!method_exists($this->_parsedUrl['controllers'], $this->_parsedUrl['action'])) {
            throw new ControllerException("Action " . $this->_parsedUrl['action'] .
                " in controller " . $this->_parsedUrl['controllers'] . " is not valid.");
        }

        $called = call_user_func_array(
            [new $this->_parsedUrl['controllers'], $this->_parsedUrl['action']],
            [$this->_urlParams, $this->_postParams]
        );

        if ($called === false) {
            throw new ControllerException("Action " . $this->_parsedUrl['action'] .
                " in controller " . $this->_parsedUrl['controllers'] . " failed.");
        }
    }
}
