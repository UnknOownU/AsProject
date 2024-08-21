<?php

namespace App\Service;

use App\Entity\Booking;
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

    public function sendAppointmentConfirmation(string $to, Booking $booking)
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Confirmation de votre rendez-vous')
            ->html($this->twig->render('emails/appointment_confirmation.html.twig', [
                'booking' => $booking
            ]));

        $this->mailer->send($email);
    }
    
    public function sendAppointmentModification(string $to, Booking $booking): void
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Modification de votre rendez-vous')
            ->html($this->twig->render('emails/appointment_edit_confirmation.html.twig', [
                'booking' => $booking
            ]));

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
