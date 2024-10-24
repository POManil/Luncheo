<?php

namespace App\Repository\OrderLine;

use App\Entity\OrderLine;

interface OrderLineRepositoryInterface
{
  public function getById(int $orderId, int $userId, int $sandwichId): ?OrderLine;
  public function removeOrderLine(OrderLine $line): void;
}