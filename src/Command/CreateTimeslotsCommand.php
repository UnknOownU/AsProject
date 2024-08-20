<?php

namespace App\Command;

use App\Entity\Timeslot;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateTimeslotsCommand extends Command
{
    protected static $defaultName = 'app:create-timeslots';
    protected static $defaultDescription = 'Créer des créneaux horaires pour les rendez-vous';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('startDate', InputArgument::REQUIRED, 'Date de début (format YYYY-MM-DD)')
            ->addArgument('endDate', InputArgument::REQUIRED, 'Date de fin (format YYYY-MM-DD)')
            ->addArgument('slotDuration', InputArgument::OPTIONAL, 'Durée de chaque créneau en minutes', 45)
            ->addOption('startTime', null, InputOption::VALUE_OPTIONAL, 'Heure de début chaque jour (format HH:MM)', '08:00')
            ->addOption('endTime', null, InputOption::VALUE_OPTIONAL, 'Heure de fin chaque jour (format HH:MM)', '17:00')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
    
        $startDateInput = $input->getArgument('startDate');
        $endDateInput = $input->getArgument('endDate');
        $slotDuration = (int)$input->getArgument('slotDuration');
        $dailyStartTime = $input->getOption('startTime');
        $dailyEndTime = $input->getOption('endTime');
    
        try {
            $startDate = new \DateTime($startDateInput);
            $endDate = new \DateTime($endDateInput);
            $endDate->setTime(23, 59, 59);
            $dailyStart = \DateTime::createFromFormat('H:i', $dailyStartTime);
            $dailyEnd = \DateTime::createFromFormat('H:i', $dailyEndTime);
    
            if ($dailyStart >= $dailyEnd) {
                $io->error('L\'heure de début quotidienne doit être antérieure à l\'heure de fin quotidienne.');
                return Command::FAILURE;
            }
    
            $currentDate = clone $startDate;
    
            while ($currentDate <= $endDate) {
                $slotStartTime = (clone $currentDate)->setTime((int)$dailyStart->format('H'), (int)$dailyStart->format('i'));
    
                while ($slotStartTime->format('H:i') < $dailyEnd->format('H:i')) {
                    $timeslot = new Timeslot();
                    $timeslot->setStartTime(clone $slotStartTime);
                    // L'heure de fin est automatiquement définie à l'intérieur de setStartTime()
    
                    $this->entityManager->persist($timeslot);
    
                    $slotStartTime = (clone $slotStartTime)->modify("+$slotDuration minutes");
                }
    
                $currentDate->modify('+1 day');
            }
    
            $this->entityManager->flush();
    
            $io->success('Les créneaux horaires ont été générés avec succès.');
    
            return Command::SUCCESS;
    
        } catch (\Exception $e) {
            $io->error('Une erreur est survenue : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}    
