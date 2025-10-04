<?php
namespace Controllers;

final class LegalController
{
    public function show(): void
    {
        \View::render('legal');
    }
}
