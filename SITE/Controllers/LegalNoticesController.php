<?php
namespace Controllers;

final class LegalNoticesController
{
    public function show(): void
    {
        // La vue a été renommée de 'legal.php' en 'legal-notices.php'
        \View::render('legal-notices');
    }
}
