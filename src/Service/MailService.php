<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService 
{
  public function __construct(private MailerInterface $mailer) {}

  public function send(
    string $from, string $to, string $subject, string $templateName, array $context
  ): void
  {
    # On Cree une instance de l'email
    $email = (new TemplatedEmail())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->htmlTemplate("email/".$templateName)
      ->context($context);


      # On envoie l'email
      $this->mailer->send($email);
  }
}