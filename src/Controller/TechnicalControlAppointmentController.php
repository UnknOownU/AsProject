<?php
namespace App\Controller;

use App\Entity\TechnicalControlAppointment;
use App\Form\TechnicalControlAppointmentType;
use App\Service\MailerService; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Uid\Uuid;

#[Route('/technical-control/appointment')]
class TechnicalControlAppointmentController extends AbstractController
{
    #[Route('/', name: 'app_technical_control_appointment_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('technical_control_appointment/index.html.twig');
    }

    #[Route('/step/{step}', name: 'app_technical_control_appointment_step', methods: ['GET', 'POST'])]
    public function step(int $step, Request $request, EntityManagerInterface $entityManager, SessionInterface $session, MailerService $mailerService): Response
    {
        $technicalControlAppointment = $session->get('appointment', new TechnicalControlAppointment());

        $form = $this->createForm(TechnicalControlAppointmentType::class, $technicalControlAppointment, ['step' => $step]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($step === 4) {
                $entityManager->persist($technicalControlAppointment);
                $entityManager->flush();
                $session->remove('appointment');

                // Envoyer un email de confirmation avec les détails modifiés
                $mailerService->sendAppointmentConfirmation($technicalControlAppointment->getEmail(), $technicalControlAppointment);

                return $this->json(['status' => 'success'], 200);
            } else {
                $session->set('appointment', $technicalControlAppointment);
                return $this->redirectToRoute('app_technical_control_appointment_step', ['step' => $step + 1]);
            }
        }

        return $this->render('technical_control_appointment/step' . $step . '.html.twig', [
            'form' => $form->createView(),
            'actionType' => 'create' // Passer 'create' pour la création
        ]);
    }

    #[Route('/edit/{uuid}/step/{step}', name: 'app_technical_control_appointment_edit_step', methods: ['GET', 'POST'])]
    public function editStep(Uuid $uuid, int $step, Request $request, EntityManagerInterface $entityManager, SessionInterface $session, MailerService $mailerService): Response
    {
        $technicalControlAppointment = $entityManager->getRepository(TechnicalControlAppointment::class)->findOneBy(['uuid' => $uuid]);

        if (!$technicalControlAppointment) {
            throw $this->createNotFoundException('Rendez-vous non trouvé.');
        }

        $now = new \DateTimeImmutable();
        $interval = $now->diff($technicalControlAppointment->getCreatedAt());

        if ($interval->days > 0 || $interval->h > 24) {
            $this->addFlash('error', 'Le délai de 24 heures pour modifier ce rendez-vous est dépassé.');
            return $this->redirectToRoute('app_technical_control_appointment_index');
        }

        // Créer le formulaire pour l'étape en cours
        $form = $this->createForm(TechnicalControlAppointmentType::class, $technicalControlAppointment, ['step' => $step]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($step === 4) {
                // Sauvegarde des modifications
                $entityManager->flush();

                // Envoyer l'email de confirmation avec les détails modifiés
                $mailerService->sendAppointmentModification($technicalControlAppointment->getEmail(), $technicalControlAppointment);

                $this->addFlash('success', 'Votre rendez-vous a été mis à jour avec succès.');
                return $this->json(['status' => 'success'], 200);
            } else {
                // Sauvegarder les modifications de l'étape courante
                $entityManager->flush();

                return $this->redirectToRoute('app_technical_control_appointment_edit_step', ['uuid' => $uuid, 'step' => $step + 1]);
            }
        }

        return $this->render('technical_control_appointment/step' . $step . '.html.twig', [
            'form' => $form->createView(),
            'actionType' => 'edit' // Indiquer qu'il s'agit d'une modification
        ]);
    }
    #[Route('/cancel/{uuid}', name: 'app_technical_control_appointment_cancel', methods: ['POST', 'GET'])]
    public function cancel(Uuid $uuid, Request $request, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        // Récupérer le rendez-vous à partir du UUID dans l'URL
        $technicalControlAppointment = $entityManager->getRepository(TechnicalControlAppointment::class)->findOneBy(['uuid' => $uuid]);
    
        if (!$technicalControlAppointment) {
            throw $this->createNotFoundException('Rendez-vous non trouvé.');
        }
    
        if ($request->isMethod('POST')) {
            // Récupérer l'UUID entré par l'utilisateur dans le formulaire
            $enteredUuid = $request->request->get('uuid');
    
            // Vérifier si l'UUID entré correspond à celui du rendez-vous
            if ($enteredUuid !== $uuid->toRfc4122()) {
                $this->addFlash('error', 'L\'UUID entré ne correspond pas. Annulation non autorisée.');
                return $this->redirectToRoute('app_technical_control_appointment_cancel', ['uuid' => $uuid]);
            }
    
            // Vérifier si le délai de 24 heures pour annuler le rendez-vous n'est pas dépassé
            $now = new \DateTimeImmutable();
            $interval = $now->diff($technicalControlAppointment->getCreatedAt());
    
            if ($interval->days > 0 || $interval->h > 24) {
                $this->addFlash('error', 'Le délai de 24 heures pour annuler ce rendez-vous est dépassé.');
                return $this->redirectToRoute('app_technical_control_appointment_index');
            }
    
            // Supprimer le rendez-vous
            $entityManager->remove($technicalControlAppointment);
            $entityManager->flush();
    
            // Envoyer un email de confirmation d'annulation
            $mailerService->sendCancellationConfirmation(
                $technicalControlAppointment->getEmail(),
                $technicalControlAppointment
            );
    
            // Ajouter un message de succès (à afficher dans l'index)
            $this->addFlash('success', 'Votre rendez-vous a été annulé avec succès.');
    
            // Rediriger vers l'index (ou autre page) après l'annulation
            return $this->redirectToRoute('app_technical_control_appointment_index', ['success' => 'true']);
        }
    
        // Retourner la vue Twig de confirmation d'annulation
        return $this->render('technical_control_appointment/cancel.html.twig', [
            'appointment' => $technicalControlAppointment
        ]);
    }
    
}
