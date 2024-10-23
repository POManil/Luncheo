<?php

namespace App\Repository\OrderLine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\OrderLine;

class OrderLineRepository extends ServiceEntityRepository implements OrderLineRepositoryInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, OrderLine::class);
  }

  public function getById(int $orderId, int $userId, int $sandwichId): ?OrderLine
  {
    $queryResult = $this->createQueryBuilder('ol')
      ->where('ol.order = :orderId')
      ->andWhere('ol.user = :userId')
      ->andWhere('ol.sandwich = :sandwichId')
      ->getQuery()
      ->setParameters([
          'orderId' => $orderId,
          'userId' => $userId,
          'sandwichId' => $sandwichId,
      ])
      ->getOneOrNullResult();

    return $queryResult;
  }
}
