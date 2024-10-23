<?php

namespace App\Repository\Order;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
// use Doctrine\ORM\Exception\ORMException;
// use InvalidArgumentException;

use App\Entity\Order;

class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Order::class);
  }

  public function getAll(): array
  {
    $queryResult = $this->createQueryBuilder('o')
      ->select('o')
      ->getQuery()
      ->getResult();

    return $queryResult;
  }
}