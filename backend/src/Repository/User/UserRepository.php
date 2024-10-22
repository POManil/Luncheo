<?php

namespace App\Repository\User;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, User::class);
  }

  public function getAll(): array
  {
    $queryResult = $this->createQueryBuilder('u')
      ->select('u')
      ->getQuery()
      ->getResult();

    return $queryResult;
  }

  public function getById(int $id): ?User
  {
    $queryResult = $this->createQueryBuilder('u')
      ->where('u.id = :id')
      ->select('u')
      ->getQuery()
      ->setParameter('id', $id)
      ->getResult();
    
    return !empty($queryResult) ? $queryResult[0] : null;
  }
}
