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
    $users = $this->createQueryBuilder('u')
      ->select('u')
      ->getQuery()
      ->getResult();

    return $users;
  }

  public function getById(int $id): User
  {
    $user = $this->createQueryBuilder('u')
      ->where('u.id = :id')
      ->select('u')
      ->getQuery()
      ->setParameter('id', $id)
      ->getResult()[0];

    return $user;
  }
}
