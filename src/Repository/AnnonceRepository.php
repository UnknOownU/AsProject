<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Annonce>
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function findDistinctValues(string $field): array
    {
        $results = $this->createQueryBuilder('a')
                        ->select("DISTINCT(a.$field) as $field")
                        ->orderBy("a.$field", 'ASC')
                        ->getQuery()
                        ->getArrayResult();
    
        // Convertir le tableau associatif en un tableau simple
        return array_column($results, $field);
    }
    
}
