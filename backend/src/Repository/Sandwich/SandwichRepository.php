<?php

namespace App\Repository\Sandwich;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Sandwich;

class SandwichRepository extends ServiceEntityRepository implements SandwichRepositoryInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Sandwich::class);
  }

  public function getById(int $id): ?Sandwich
  {
    $queryResult = $this->createQueryBuilder('s')
      ->select('s')
      ->where('s.id = :id')
      ->getQuery()
      ->setParameter('id', $id)
      ->getResult();
    
    return !empty($queryResult) ? $queryResult[0] : null;
  }
}
