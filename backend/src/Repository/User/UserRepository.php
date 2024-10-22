<?php

namespace App\Repository\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Exception\ORMException;
use InvalidArgumentException;

use App\Entity\User;

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

  public function getByEmail(string $email): ?User
  {
    $queryResult = $this->createQueryBuilder('u')
      ->where('u.email = :email')
      ->select('u')
      ->getQuery()
      ->setParameter('email', $email)
      ->getResult();

    return !empty($queryResult) ? $queryResult[0] : null;
  }

  public function login (string $email, string $password): ?User
  {
    $queryResult = $this->createQueryBuilder('u')
      ->where('u.email = :email AND u.password = :password')
      ->select('u')
      ->getQuery()
      ->setParameters(['email' => $email, 'password' => $password])
      ->getResult();

    return !empty($queryResult) ? $queryResult[0] : null;
  }

  public function createUser(User $user): bool
  {
    if(is_null($user)) {
      throw new InvalidArgumentException("`mapFromUser`: param 'User' should not be null.");
    }

    $entityManager = $this->getEntityManager();
    try {
      $entityManager->persist($user);
      $entityManager->flush();
      return true;
    } catch (ORMException $e) {
      throw $e;
    }
  }
}
