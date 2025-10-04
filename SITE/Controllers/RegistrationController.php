<?php
namespace Controllers;

final class RegistrationController
{
    private AuthController $auth;

    public function __construct()
    {
        $this->auth = new AuthController();
    }

    public function show(): void
    {
        $this->auth->showRegister();
    }

    public function submit(): void
    {
        $this->auth->register();
    }
}
