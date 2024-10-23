<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Entity\OrderLine;

class OrderLineDTO
{
  public ?int $userId;
  public ?int $sandwichId;
  public ?float $price;
  public ?int $quantity;

  public function __construct(?int $userId, ?int $sandwichId, ?float $price, ?int $quantity)
  {
    $this->userId = $userId;
    $this->sandwichId = $sandwichId;
    $this->price = $price;
    $this->quantity = $quantity;
  }

  public static function mapFromOrderLine(OrderLine $orderLine): self
  {
    if (is_null($orderLine)) {
      throw new InvalidArgumentException("`mapFromOrderLine`: param 'orderLine' should not be null.");
    }

    return new self(
      $orderLine->getUser()->getId(),
      $orderLine->getSandwich()->getId(),
      $orderLine->getPrice(),
      $orderLine->getQuantity()
    );
  }
}
