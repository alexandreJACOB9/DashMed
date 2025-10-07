<?php
namespace Core;

final class Mailer
{
    //envoi via mail après inscription
    public static function sendRegistrationEmail(string $to, string $name, string $lastName = ''): bool
    {
        $fullName = trim($name . ' ' . $lastName);
        $subject = 'Inscription DashMed';

        $from = 'no-reply@dashmed-site.alwaysdata.net';

        $headers = [
            'From: DashMed <' . $from . '>',
            'Reply-To: ' . $from,
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
        ];

        $body = '<!doctype html><html><body>'
            . '<p>Bonjour ' . htmlspecialchars($fullName ?: '!', ENT_QUOTES, 'UTF-8') . ',</p>'
            . '<p>Bienvenue sur DashMed ! Votre compte a bien été créé.</p>'
            . '<p>À très vite,<br>L’équipe DashMed</p>'
            . '</body></html>';

        $envelopeFrom = '-f ' . $from;

        return mail($to, $subject, $body, implode("\r\n", $headers), $envelopeFrom);
    }
}