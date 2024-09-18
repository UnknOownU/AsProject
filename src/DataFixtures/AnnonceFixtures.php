<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Image;
use App\Entity\CarOptions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Options disponibles
        $optionNames = [
            'Climatisation', 
            'GPS', 
            'Sièges chauffants', 
            'Bluetooth', 
            'Caméra de recul', 
            'Radar de stationnement', 
            'Toit ouvrant', 
            'Régulateur de vitesse', 
            'Vitres teintées',
            'Système de navigation'
        ];

        // Création des options de voiture (CarOptions)
        $carOptions = [];
        foreach ($optionNames as $optionName) {
            $option = new CarOptions();
            $option->setName($optionName);
            $manager->persist($option);
            $carOptions[] = $option;
        }

        $manager->flush();

        // Liste des marques et descriptions pour générer les données
        $brands = [
            ['brand' => 'Toyota', 'models' => ['Corolla', 'Camry', 'Yaris', 'RAV4']],
            ['brand' => 'BMW', 'models' => ['320i', 'X5', 'M3', 'Z4']],
            ['brand' => 'Mercedes', 'models' => ['C-Class', 'E-Class', 'GLC', 'GLE']],
            ['brand' => 'Audi', 'models' => ['A4', 'Q5', 'A3', 'A6']],
            ['brand' => 'Ford', 'models' => ['Fiesta', 'Focus', 'Mustang', 'Explorer']],
            ['brand' => 'Honda', 'models' => ['Civic', 'Accord', 'CR-V', 'Jazz']],
            ['brand' => 'Nissan', 'models' => ['Qashqai', 'Juke', 'Leaf', 'X-Trail']],
            ['brand' => 'Chevrolet', 'models' => ['Malibu', 'Equinox', 'Camaro', 'Spark']],
            ['brand' => 'Kia', 'models' => ['Rio', 'Sportage', 'Sorento', 'Picanto']],
            ['brand' => 'Hyundai', 'models' => ['i20', 'i30', 'Tucson', 'Santa Fe']],
        ];

        $descriptions = [
            'Voiture bien entretenue avec faible consommation de carburant, idéale pour la ville.',
            'Modèle récent, équipé des dernières technologies de sécurité et de confort.',
            'Voiture spacieuse et confortable, parfaite pour les longs trajets en famille.',
            'Design élégant et performances sportives pour les amateurs de conduite dynamique.',
            'Modèle hybride, économique et écologique, avec une autonomie impressionnante.',
            'Voiture robuste et fiable, avec un entretien régulier effectué par un concessionnaire agréé.',
            'Modèle de luxe avec intérieur en cuir et finitions haut de gamme.',
            'Voiture compacte, idéale pour la conduite en milieu urbain, avec un faible coût d’entretien.',
            'SUV puissant avec une capacité de remorquage élevée, parfait pour les aventures en plein air.',
            'Modèle d’occasion en excellent état, avec un historique de maintenance complet.',
        ];

        $fuels = ['Essence', 'Diesel', 'Hybride', 'Électrique'];
        $gearboxes = ['Manuelle', 'Automatique'];

        for ($i = 1; $i <= 25; $i++) {
            $brandData = $brands[array_rand($brands)];
            $brand = $brandData['brand'];
            $model = $brandData['models'][array_rand($brandData['models'])];

            $year = rand(2015, 2022);
            $mileage = rand(10000, 150000);
            $price = rand(15000, 60000);
            $enginePower = rand(100, 400);
            $doors = rand(3, 5);
            $seats = rand(4, 7);
            $fuel = $fuels[array_rand($fuels)];
            $gearbox = $gearboxes[array_rand($gearboxes)];
            $color = $faker->safeColorName();
            $vin = strtoupper($faker->bothify('??###??###????###'));

            $annonce = new Annonce();
            $annonce->setTitle("{$brand} {$model} {$year}")
                    ->setDescription($descriptions[array_rand($descriptions)])
                    ->setCarname("{$brand} {$model}")
                    ->setBrand($brand)
                    ->setKilometrage($mileage)
                    ->setEngine("{$enginePower} ch - {$fuel} - VIN: {$vin}")
                    ->setGearbox($gearbox)
                    ->setFuel($fuel)
                    ->setProvenance($faker->country())
                    ->setYear((string)$year)
                    ->setRegistrationDate($faker->dateTimeBetween('-5 years', 'now'))
                    ->setTechnicalControl($faker->boolean(80) ? 'Valide' : 'À refaire')
                    ->setFirstHand($faker->boolean(50))
                    ->setColor(ucfirst($color))
                    ->setDoors((string)$doors)
                    ->setSeats($seats)
                    ->setFiscalPower(rand(5, 15))
                    ->setFuelConsumption($fuel === 'Électrique' ? rand(15, 25) : rand(4, 10))
                    ->setHorsePower($enginePower)
                    ->setPrice($price);

            // Ajouter des options aléatoires à l'annonce
            $selectedOptions = (array)array_rand($carOptions, rand(1, 4));
            foreach ($selectedOptions as $optionIndex) {
                $annonce->addCarOption($carOptions[$optionIndex]); // Utiliser addCarOption pour CarOptions
            }

            // Générer plusieurs images pour chaque annonce
            for ($j = 1; $j <= 3; $j++) { 
                $image = new Image();
                $imageFileIndex = rand(1, 12); // Sélectionner une image aléatoire entre car-1.jpg et car-12.jpg
                
                $filePath = __DIR__ . "/../../public/images/car-$imageFileIndex.jpg";
                if (file_exists($filePath)) {
                    $imageData = file_get_contents($filePath);
                    $image->setData($imageData);
                    $image->setAnnonce($annonce);
                    $manager->persist($image);
                } else {
                    echo "Le fichier $filePath n'existe pas.\n";
                }
            }

            $manager->persist($annonce);
        }

        $manager->flush();
    }
}
