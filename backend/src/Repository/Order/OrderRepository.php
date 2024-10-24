<?php

namespace App\Repository\Order;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Exception\ORMException;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Repository\OrderLine\OrderLineRepositoryInterface;

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

  public function updateOrder(Order $order): void
  {
    if (is_null($order)) {
      throw new \InvalidArgumentException("`updateOrder`: param 'order' should not be null.");
    }

    $entityManager = $this->getEntityManager();

    try {
      $orderEntity = $this->getById($order->getId());
      $orderEntity->setOrderDate($order->getOrderDate());
      $orderEntity->setPaid($order->isPaid());

      $entityManager->flush();
    } catch (ORMException $e) {
      throw $e;
    }
  }

  public function upsertOrderLine(Order $order, OrderLine $line): void
  {
    if (is_null($order)) {
      throw new \InvalidArgumentException("`upsertOrderLine`: param 'order' should not be null.");
    }

    if (is_null($line)) {
      throw new \InvalidArgumentException("`upsertOrderLine`: param 'line' should not be null.");
    }
    
    $entityManager = $this->getEntityManager();
    
    try {
      $existingLine = $this->orderLineRepository->getById(
        $order->getId(),
        $line->getUser()->getId(),
        $line->getSandwich()->getId()
      );

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

  public function removeOrderLine(Order $order, OrderLine $line): void
  {
    if (is_null($line)) {
      throw new \InvalidArgumentException("`removeOrderLine`: param 'line' should not be null.");
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

  public function removeOrder(Order $order): void
  {
    if(is_null($order)) {
      throw new \InvalidArgumentException("`removeOrder`: param 'order' should not be null.");
    }

    $entityManager = $this->getEntityManager();
    try {
      $entityManager->remove($order);
      $entityManager->flush();
    } catch (ORMException $e) {
      throw $e;
    }
  }
}
