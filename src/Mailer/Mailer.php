<?php


namespace App\Mailer;


use App\Entity\User;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Email address send from
     * (global variable from services.yaml)
     */
    private $mail_from;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, $mailFrom)
    {
        $this->mailer    = $mailer;
        $this->twig      = $twig;
        $this->mail_from = $mailFrom;
    }


    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render('email/registration.html.twig', ['user' => $user]);

        $message = (new \Swift_Message())
            ->setFrom($this->mail_from)
            ->setTo($user->getEmail())
            ->setSubject('Welcome message!')
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

}