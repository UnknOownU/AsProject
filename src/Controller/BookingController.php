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
        
        // Récupérer tous les créneaux horaires disponibles
        $allTimeslots = $entityManager->getRepository(Timeslot::class)->findBy([], ['startTime' => 'ASC']);
    
        $now = new \DateTime(); // Date et heure actuelles
    
        // Filtrer les créneaux horaires pour exclure ceux dans moins de 12 heures
        $filteredTimeslots = array_filter($allTimeslots, function($timeslot) use ($now) {
            return ($timeslot->getStartTime()->getTimestamp() - $now->getTimestamp()) >= 43200; // 43200 secondes = 12 heures
        });
    
        $timeslotsByDay = [];
        $hours = [];
        $days = [];
    
        foreach ($filteredTimeslots as $timeslot) {
            $day = $timeslot->getStartTime()->format('Y-m-d'); // Format uniforme pour les clés
            $hour = $timeslot->getStartTime()->format('H:i');
            
            // Grouper les créneaux horaires par jour
            if (!isset($timeslotsByDay[$day])) {
                $timeslotsByDay[$day] = [];
            }
    
            $timeslotsByDay[$day][$hour] = [
                'slot' => $timeslot
            ];
    
            // Ajouter l'heure à la liste des heures disponibles si elle n'existe pas déjà
            if (!in_array($hour, $hours)) {
                $hours[] = $hour;
            }
        }
    
        // Trier la liste des heures
        sort($hours);
    
        // Calcul des jours à afficher
        $startDate = new \DateTime(); // Date actuelle
        for ($i = 0; $i < 7; $i++) {
            $dayDate = clone $startDate; // Clone pour ne pas modifier l'original
            $days[] = [
                'date' => $dayDate->format('Y-m-d'), // Utilisation du même format que les clés
                'display' => $dayDate->format('l d F') // Format pour affichage
            ];
            $startDate->modify('+1 day');
        }
        
        // Générez un token CSRF pour la sécurité
        $csrfToken = $csrfTokenManager->getToken('create_timeslot')->getValue();
    
        $form = $this->createForm(BookingType::class, $booking);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'ID du créneau horaire sélectionné
            $selectedTimeslotId = $request->request->get('selectedSlotId');
            
            // Vérifier que l'ID est bien transmis
            if (!$selectedTimeslotId) {
                $this->addFlash('error', 'Aucun créneau horaire sélectionné.');
                return $this->redirectToRoute('app_booking_new');
            }
    
            // Récupérer le créneau à partir de l'ID
            $selectedTimeslot = $entityManager->getRepository(Timeslot::class)->find($selectedTimeslotId);
    
            // Vérifier si le créneau est valide et disponible
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
            'timeslotsByDay' => $timeslotsByDay,
            'hours' => $hours,
            'days' => $days,
            'csrf_token' => $csrfToken,
        ]);
    }
}
