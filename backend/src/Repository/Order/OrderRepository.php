<?php

namespace App\Repository\Order;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Order;
use App\Entity\OrderLine;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\Exception\ORMException;

class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Order::class);
  }

  public function getAll(): array
  {
    $queryResult = $this->createQueryBuilder('o')
    ->select('o', 'ol', 'u', 's')
    ->join('o.lines', 'ol')
    ->join('ol.user', 'u')
    ->join('ol.sandwich', 's')
    ->getQuery()
    ->getResult();

    return $queryResult;
  }

  public function createOrder(Order $order): int
  {
    if (is_null($order)) {
      throw new InvalidArgumentException("`createOrder`: param 'order' should not be null.");
    }

    $entityManager = $this->getEntityManager();

    if(is_null($order->getOrderDate())) {
      $order->setOrderDate(new \DateTime());
    }

    try {
      $entityManager->persist($order);
      $entityManager->flush();
      return $order->getId();
    } catch (ORMException $e) {
      throw $e;
    }
  }

  public function addOrderLine(Order $order, OrderLine $line): void
  {
    if (is_null($order)) {
      throw new InvalidArgumentException("`addOrderLine`: param 'order' should not be null.");
    }

    if (is_null($line)) {
      throw new InvalidArgumentException("`addOrderLine`: param 'line' should not be null.");
    }

    $entityManager = $this->getEntityManager();
    $line->setOrder($order);
    $order->addLine($line);

    try {
      $entityManager->persist($line);
      $entityManager->flush();
    } catch (ORMException $e) {
      throw $e;
    }
  }

  public function removeOrderLine(OrderLine $line): void
  {
    if (is_null($line)) {
      throw new InvalidArgumentException("`removeOrderLine`: param 'line' should not be null.");
    }

    $entityManager = $this->getEntityManager();

    try {
      $order = $line->getOrder();
      if (!is_null($order)) {
        $order->removeLine($line);
      }

      $entityManager->remove($line);
      $entityManager->flush();
    } catch (ORMException $e) {
      throw $e;
    }
  }
}
