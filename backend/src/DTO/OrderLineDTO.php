<?php

namespace App\DTO;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Sandwich;
use App\Entity\User;

class OrderLineDTO
{
  public ?int $orderId;
  public ?int $userId;
  public ?int $sandwichId;
  public ?float $price;
  public ?int $quantity;

  public function __construct(?int $orderId, ?int $userId, ?int $sandwichId, ?float $price, ?int $quantity)
  {
    $this->orderId = $orderId;
    $this->userId = $userId;
    $this->sandwichId = $sandwichId;
    $this->price = $price;
    $this->quantity = $quantity;
  }

  public static function mapFromOrderLine(OrderLine $orderLine): self
  {
    if (is_null($orderLine)) {
      throw new \InvalidArgumentException("`mapFromOrderLine`: param 'orderLine' should not be null.");
    }

    return new self(
      $orderLine->getOrder()->getId(),
      $orderLine->getUser()->getId(),
      $orderLine->getSandwich()->getId(),
      $orderLine->getPrice(),
      $orderLine->getQuantity()
    );
  }

  public static function mapToOrderLine(self $dto, Sandwich $sandwich, Order $order, User $user): OrderLine
  {
    if (is_null($dto)) {
      throw new \InvalidArgumentException("`mapToOrderLine`: param 'dto' should not be null.");
    }

    if (is_null($sandwich)) {
      throw new \InvalidArgumentException("`mapToOrderLine`: param 'sandwich' should not be null.");
    }  

    if (is_null($order)) {
      throw new \InvalidArgumentException("`mapToOrderLine`: param 'order' should not be null.");
    }  

    if (is_null($user)) {
      throw new \InvalidArgumentException("`mapToOrderLine`: param 'user' should not be null.");
    }

    return new OrderLine(
      $order,
      $sandwich,
      $user,
      $dto->quantity
    );
  }
}
