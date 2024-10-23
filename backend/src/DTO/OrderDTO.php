<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Entity\Order;

class OrderDTO
{
  public ?int $id;
  public ?\DateTime $orderDate;
  public ?bool $isPaid;

  public function __construct(?int $id, \DateTime $orderDate, ?bool $isPaid)
  {
    $this->id = $id;
    $this->orderDate = $orderDate;
    $this->isPaid = $isPaid;
  }

  public static function mapFromOrder(Order $order): self
  {
    if(is_null($order)) {
      throw new InvalidArgumentException("`mapFromOrder`: param 'order' should not be null.");
    }

    return new self(
      $order->getId(),
      $order->getOrderDate(),
      $order->isPaid()
    );
  }

  public static function mapToOrder(self $dto): Order
  {
    if(is_null($dto)) {
      throw new InvalidArgumentException("`mapToOrder`: param 'dto' should not be null.");
    }

    $order = new order();
    $order->setOrderDate($dto->orderDate);
    $order->setPaid($dto->isPaid);

    return $order;
  }
}
