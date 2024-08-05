<?php

// src/DataFixtures/AnnonceFixtures.php

namespace App\DataFixtures;

use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = ['Toyota', 'BMW', 'Mercedes', 'Audi', 'Ford', 'Honda', 'Nissan', 'Chevrolet', 'Kia', 'Hyundai'];
        $descriptions = [
            'Une voiture fiable et économique, idéale pour les trajets quotidiens.',
            'Voiture sportive avec des performances exceptionnelles et un design élégant.',
            'Luxueuse et confortable, parfaite pour les longs trajets.',
            'Une voiture de qualité allemande avec une finition impeccable.',
            'Voiture robuste et durable, idéale pour les familles.',
            'Compacte et maniable, parfaite pour la ville.',
            'Voiture spacieuse avec un grand coffre pour les voyages en famille.',
            'Voiture américaine avec un moteur puissant.',
            'Voiture économique avec une faible consommation de carburant.',
            'Voiture moderne avec toutes les dernières technologies.'
        ];
        $gearboxes = ['Manuelle', 'Automatique'];

        for ($i = 1; $i <= 100; $i++) {
            $brand = $brands[array_rand($brands)];
            $description = $descriptions[array_rand($descriptions)];
            $gearbox = $gearboxes[array_rand($gearboxes)];

            $annonce = new Annonce();
            $annonce->setTitle('Annonce ' . $i)
                    ->setDescription($description)
                    ->setCarname($brand . ' Modèle ' . $i)
                    ->setBrand($brand)
                    ->setKilometrage(rand(5000, 200000))
                    ->setEngine('Moteur ' . $i)
                    ->setGearbox($gearbox)
                    ->setFuel('Essence')
                    ->setProvenance('France')
                    ->setYear((string)rand(2010, 2020))
                    ->setRegistrationDate(new \DateTime('now'))
                    ->setTechnicalControl('Requis')
                    ->setFirstHand(rand(0, 1) === 1)
                    ->setColor('Couleur ' . $i)
                    ->setDoors((string)rand(3, 5))
                    ->setSeats(rand(4, 7))
                    ->setFiscalPower(rand(5, 10))
                    ->setHorsePower(rand(100, 300))
                    ->setImage('images/default_car_image.jpg') // Placeholder for image data
                    ->setPrice(rand(5000, 50000));

            $manager->persist($annonce);
        }

        $manager->flush();
    }
}

