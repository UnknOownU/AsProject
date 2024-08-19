<?php

namespace App\DataFixtures;

use App\Entity\TechnicalControlAppointment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class TechnicalControlAppointmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Types de contrôle technique
        $controlTypes = [
            'Contrôle technique réglementaire', 
            'Contre-visite', 
            'Contrôle antipollution', 
            'Contrôle technique volontaire'
        ];

        // Types de véhicules
        $carTypes = ['Berline', 'SUV', 'Coupé', 'Break', 'Monospace'];

        for ($i = 1; $i <= 50; $i++) {
            $appointment = new TechnicalControlAppointment();
            $appointment->setFirstname($faker->firstName)
                        ->setLastname($faker->lastName)
                        ->setEmail($faker->email)
                        ->setPhone($faker->phoneNumber)
                        ->setCarBrand($faker->company)
                        ->setCarModel($faker->word)
                        ->setLicensePlate(strtoupper($faker->bothify('??###??')))
                        ->setFuelType($faker->randomElement(['Essence', 'Diesel', 'Hybride', 'Électrique']))
                        ->setComments($faker->optional()->sentence)
                        ->setControlType($faker->randomElement($controlTypes))
                        ->setCarType($faker->randomElement($carTypes));

            $manager->persist($appointment);
        }

        $manager->flush();
    }
}
