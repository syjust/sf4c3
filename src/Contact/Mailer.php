<?php

namespace App\Contact;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private $recipient;
    private $mailer;

    public function __construct(string $recipient, MailerInterface $mailer)
    {
        $this->recipient = $recipient;
        $this->mailer = $mailer;
    }

    public function sendMail(Contact $contact): void
    {
        $message = $this->mailer->createMessage()
            ->setTo($this->recipient)
            ->setFrom($contact->sender)
            ->setSubject($contact->subject)
            ->setBody($contact->message)
        ;

        $this->mailer->send($message);
    }
}
