<?php

namespace App\DataFixtures;

use App\Entity\TechnicalControlAppointment;
use App\Entity\Timeslot;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TechnicalControlAppointmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $controlTypes = [
            'Contrôle technique réglementaire',
            'Contre-visite',
            'Contrôle antipollution',
            'Contrôle technique volontaire'
        ];

        $fuels = ['Essence', 'Diesel', 'Hybride', 'Électrique'];
        $carTypes = ['Voiture', 'Camion', 'Moto'];

        for ($i = 0; $i < 20; $i++) {
            $timeslot = new Timeslot();
            $startTime = $faker->dateTimeBetween('+1 days', '+10 days');

            $timeslot->setStartTime($startTime)
                ->setIsAvailable($faker->boolean(70)); // 70% de chances que le créneau soit disponible

            $manager->persist($timeslot);

            if ($timeslot->isAvailable()) {
                // Créer un rendez-vous pour ce créneau
                $appointment = new TechnicalControlAppointment();
                $appointment->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setEmail($faker->email())
                    ->setPhone($faker->phoneNumber())
                    ->setCarBrand($faker->company())
                    ->setCarModel($faker->word())
                    ->setLicensePlate(strtoupper($faker->bothify('??###??')))
                    ->setFuelType($fuels[array_rand($fuels)])
                    ->setControlType($controlTypes[array_rand($controlTypes)])
                    ->setCarType($carTypes[array_rand($carTypes)])
                    ->setTimeslot($timeslot);

                $timeslot->setAppointment($appointment);
                $manager->persist($appointment);
            }
        }

        $manager->flush();
    }
}
