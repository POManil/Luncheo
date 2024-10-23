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
    ->leftJoin('o.lines', 'ol')
    ->leftJoin('ol.user', 'u')
    ->leftJoin('ol.sandwich', 's')
    ->getQuery()
    ->getResult();

    return $queryResult;
  }

  public function getById(int $id): ?Order
  {
    $queryResult = $this->createQueryBuilder('o')
    ->select('o', 'ol', 'u', 's')
    ->leftJoin('o.lines', 'ol')
    ->leftJoin('ol.user', 'u')
    ->leftJoin('ol.sandwich', 's')
    ->where("o.id = :id")
    ->getQuery()
    ->setParameter('id', $id)
    ->getResult();

    dump("queryResult:");
    dump($queryResult);
    
    return !empty($queryResult) ? $queryResult[0] : null;
  }

  public function createOrder(): int
  {
    $order = new Order();
    $order->setPaid(false);
    $order->setOrderDate(new \DateTime());

    $entityManager = $this->getEntityManager();

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
