<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Timeslot;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use DateTime;
use DateInterval;
use DatePeriod;



class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/booking/new', name: 'app_booking_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $booking = new Booking();
        $booking->setStatus('Créé');
    
        // Récupérer tous les créneaux horaires disponibles, triés par heure de début
        $allTimeslots = $entityManager->getRepository(Timeslot::class)->findBy(
            [],
            ['startTime' => 'ASC']
        );
    
        $timeslotsByDay = [];
        $hours = [];
    
        foreach ($allTimeslots as $timeslot) {
            $day = $timeslot->getStartTime()->format('l'); // Récupère le jour complet (e.g., "Monday")
            $hour = $timeslot->getStartTime()->format('H:i'); // Récupère l'heure (e.g., "08:00")
    
            // Grouper les créneaux horaires par jour
            $timeslotsByDay[$day][$hour] = $timeslot;
    
            // Ajouter l'heure à la liste des heures disponibles si elle n'existe pas déjà
            if (!in_array($hour, $hours)) {
                $hours[] = $hour;
            }
        }
    
        // Trier la liste des heures
        sort($hours);
    
        // Calcul des jours à afficher
        $startDate = new DateTime(); // Date actuelle
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $days[] = $startDate->format('l d F'); // e.g., "Monday 20 August"
            $startDate->modify('+1 day');
        }
    
        // Générez un token CSRF pour la sécurité
        $csrfToken = $csrfTokenManager->getToken('create_timeslot')->getValue();
    
        $form = $this->createForm(BookingType::class, $booking);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedTimeslotId = $request->request->get('timeslot');
            $selectedTimeslot = $entityManager->getRepository(Timeslot::class)->find($selectedTimeslotId);
    
            if ($selectedTimeslot && $selectedTimeslot->isAvailable()) {
                $selectedTimeslot->setIsAvailable(false);
                $booking->setTimeslot($selectedTimeslot);
                $entityManager->persist($booking);
                $entityManager->flush();
    
                $this->addFlash('success', 'Votre rendez-vous a été créé avec succès !');
                return $this->redirectToRoute('app_booking_success');
            } else {
                $this->addFlash('error', 'Le créneau sélectionné est indisponible.');
            }
        }
    
        return $this->render('booking/new/new.html.twig', [
            'form' => $form->createView(),
            'timeslotsByDay' => $timeslotsByDay, // Passe les créneaux groupés par jour au template
            'hours' => $hours, // Passe les heures disponibles au template
            'days' => $days, // Passe les jours au template
            'csrf_token' => $csrfToken, // Passe le token CSRF au template
        ]);
    }

    
    
    public function createTimeslots(\DateTimeInterface $startDate, \DateTimeInterface $endDate, int $slotDuration)
    {
        $currentTime = clone $startDate;
    
        while ($currentTime < $endDate) {
            $endTime = (clone $currentTime)->modify("+$slotDuration minutes");
            
            $timeslot = new Timeslot();
            $timeslot->setStartTime($currentTime);
            $timeslot->setEndTime($endTime);
            $timeslot->setIsAvailable(true);
    
            $this->entityManager->persist($timeslot);
            $currentTime = $endTime;
        }
    
        $this->entityManager->flush();
    }
       
    
}