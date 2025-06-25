<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationEmail(string $toEmail, string $token): bool
    {
        $email = (new Email())
            ->from('vincentmcdoom@cyna.fr')
            ->to($toEmail)
            ->subject('Validez votre compte CYNA')
            ->html("<p>Bonjour,</p><p>Merci de confirmer votre inscription en cliquant sur ce lien :</p><p><a href='https://s5-5717.nuage-peda.fr/cyna-api/api/valider-inscription/{$token}'>Valider mon compte</a></p><p>Ce lien expire dans 24h.</p>");

        try {
            $this->mailer->send($email);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

}
