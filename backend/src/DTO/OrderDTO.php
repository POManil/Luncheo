<?php

namespace App\DTO;

use InvalidArgumentException;
use App\Entity\Order;
use Doctrine\Common\Collections\Collection;

class OrderDTO
{
  public ?int $id;
  public ?\DateTime $orderDate;
  public ?bool $isPaid;
  public ?array $lines;

  public function __construct(?int $id, \DateTime $orderDate, ?bool $isPaid, ?Collection $lines)
  {
    $this->id = $id;
    $this->orderDate = $orderDate;
    $this->isPaid = $isPaid;
    $this->lines = [];

    if (!empty($lines)) {
      foreach($lines as $line) {
        $lineDto = OrderLineDTO::mapFromOrderLine($line);
        $this->lines[] = $lineDto;
      }
    }
  }

  public static function mapFromOrder(Order $order): self
  {
    if(is_null($order)) {
      throw new InvalidArgumentException("`mapFromOrder`: param 'order' should not be null.");
    }

    return new self(
      $order->getId(),
      $order->getOrderDate(),
      $order->isPaid(),
      $order->getLines()
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

    if(!empty($dto->lines)) {
      foreach($dto->lines as $line) {
        $order->addLine($line);
      }
    }

    return $order;
  }
}
