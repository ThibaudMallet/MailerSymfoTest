<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as MimeEmail;
use Twig\Environment;

class MailerService 
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * MailerService constructor
     * 
     * @param MailerInterface $mailer
     * @param Environment $twig
     */
    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $template
     * @param array $parameters
     */
    public function send(string $subject, string $from, string $to, string $template, array $parameters): void
    {
        $email = (new MimeEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html(
                $this->twig->render($template, $parameters),
            );

        $this->mailer->send($email);        
    }

}