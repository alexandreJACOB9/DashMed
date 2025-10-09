<?php
namespace Core;

final class Mailer
{
    public static function sendRegistrationEmail(string $to, string $name, ?string $from = null): bool
    {
        $from = $from ?: 'dashmed-site@alwaysdata.net';
        $subject = 'Bienvenue sur DashMed';

        $headers = [
            'From: DashMed <' . $from . '>',
            'Reply-To: ' . $from,
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
        ];

        $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $body = '<!doctype html><html><body>'
            . '<p>Bonjour ' . $safeName . ',</p>'
            . '<p>Bienvenue sur DashMed ! Votre compte a bien été créé.</p>'
            . '<p>Vous pouvez dès à présent vous connecter et commencer à utiliser notre application pour gérer votre tableau de bord en toute simplicité.</p>'
            . '<p>Si vous n’êtes pas à l’origine de cette inscription, ignorez ce message ou contactez le support.</p>'
            . '<p>À très vite,<br>L’équipe DashMed</p>'
            . '</body></html>';

        //définit l’enveloppe expéditeur
        $envelopeFrom = '-f ' . $from;

        $ok = @mail($to, $subject, $body, implode("\r\n", $headers), $envelopeFrom);

        // Log minimal pour si ça envoie
        error_log(sprintf('[MAIL] to=%s from=%s subject="%s" result=%s', $to, $from, $subject, $ok ? 'OK' : 'FAIL'));

        return $ok;
    }
}