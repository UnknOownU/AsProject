<?php

namespace App\Service;

use App\Entity\TechnicalControlAppointment; // Import de la classe nécessaire
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerService
{
    private $mailer;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendAppointmentConfirmation($to, TechnicalControlAppointment $appointment)
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Confirmation de votre rendez-vous')
            ->html($this->twig->render('emails/appointment_confirmation.html.twig', [
                'appointment' => $appointment
            ]));

        $this->mailer->send($email);
    }
    
    public function sendAppointmentModification(string $toEmail, TechnicalControlAppointment $appointment): void
    {
        $htmlContent = $this->twig->render('emails/appointment_edit_confirmation.html.twig', [
            'appointment' => $appointment
        ]);

        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($toEmail)
            ->subject('Modification de votre rendez-vous')
            ->html($htmlContent);

        $this->mailer->send($email);
    }
    
    
    public function sendCancellationConfirmation($to, TechnicalControlAppointment $appointment)
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Annulation de votre rendez-vous')
            ->html($this->twig->render('emails/appointment_cancellation_confirmation.html.twig', [
                'appointment' => $appointment
            ]));

        $this->mailer->send($email);
    }
}
