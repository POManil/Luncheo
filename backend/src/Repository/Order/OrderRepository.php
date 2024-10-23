<?php

namespace App\Repository\Order;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Repository\OrderLine\OrderLineRepositoryInterface;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\Exception\ORMException;

class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
  private $orderLineRepository;

  public function __construct(ManagerRegistry $registry, OrderLineRepositoryInterface $orderLineRepository)
  {
    parent::__construct($registry, Order::class);
    $this->orderLineRepository = $orderLineRepository;
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

  public function upsertOrderLine(Order $order, OrderLine $line): void
  {
    if (is_null($order)) {
      throw new InvalidArgumentException("`addOrderLine`: param 'order' should not be null.");
    }

    if (is_null($line)) {
      throw new InvalidArgumentException("`addOrderLine`: param 'line' should not be null.");
    }

    $entityManager = $this->getEntityManager();

    $existingLine = $this->orderLineRepository->getById(
      $order->getId(),
      $line->getUser()->getId(),
      $line->getSandwich()->getId()
    );

    try {
      if(is_null($existingLine)) {
        $order->upsertLine($line);
        $entityManager->persist($line);
      } else {
        $existingLine->setQuantity($line->getQuantity());
        $existingLine->setSandwich($line->getSandwich());
        $existingLine->setUser($line->getUser());
      }

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
