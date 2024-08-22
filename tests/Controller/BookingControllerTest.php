<?php
namespace App\Tests\Controller;

use App\Entity\Booking;
use App\Entity\Timeslot;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{
    public function testNewBooking()
    {
        // Démarrer la mesure du temps total
        $start = microtime(true);

        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Mesurer le temps de récupération du créneau
        $startFetch = microtime(true);
        $timeslot = $entityManager->getRepository(Timeslot::class)->findOneBy(['isAvailable' => true]);
        $endFetch = microtime(true);

        $this->assertNotNull($timeslot, 'Aucun créneau horaire disponible trouvé pour le test.');

        // Rafraîchir l'entité pour s'assurer qu'elle est gérée
        $entityManager->refresh($timeslot);

        // Assurez-vous que l'entité est gérée par Doctrine
        $this->assertTrue($entityManager->contains($timeslot), 'Le créneau horaire n\'est pas géré par Doctrine.');

        // Mesurer le temps de rendu de la page
        $startRender = microtime(true);
        $crawler = $client->request('GET', '/booking/new');
        $endRender = microtime(true);

        // Assurez-vous que la réponse est correcte
        $this->assertResponseIsSuccessful();

        // Simuler le remplissage du formulaire
        $form = $crawler->selectButton('Confirmer la réservation')->form([
            'booking[inspectionForm][carType]' => 'VP',
            'booking[inspectionForm][fuelType]' => 'Essence',
            'booking[inspectionForm][controlType]' => 'CTP',
            'booking[inspectionForm][firstname]' => 'John',
            'booking[inspectionForm][lastname]' => 'Doe',
            'booking[inspectionForm][email]' => 'johndoe@example.com',
            'booking[inspectionForm][phone]' => '0123456789',
            'booking[inspectionForm][carBrand]' => 'Renault',
            'booking[inspectionForm][carModel]' => 'Clio',
            'booking[inspectionForm][licensePlate]' => 'AB-123-CD',
            'selectedSlotId' => $timeslot->getId(), // Passer l'ID du créneau horaire sélectionné
        ]);

        // Mesurer le temps de soumission du formulaire
        $startSubmit = microtime(true);
        $client->submit($form);
        $endSubmit = microtime(true);

        // Vérifier la redirection après la soumission
        $this->assertResponseRedirects('/booking/success');

        // Suivre la redirection
        $crawler = $client->followRedirect();

        // Fin de la mesure du temps total
        $end = microtime(true);

        // Afficher les temps mesurés
        echo "\nTemps de récupération du créneau : " . round(($endFetch - $startFetch) * 1000, 2) . " ms";
        echo "\nTemps de rendu de la page : " . round(($endRender - $startRender) * 1000, 2) . " ms";
        echo "\nTemps de soumission du formulaire : " . round(($endSubmit - $startSubmit) * 1000, 2) . " ms";
        echo "\nTemps total du test : " . round(($end - $start) * 1000, 2) . " ms";
    }
}
