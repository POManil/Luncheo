<?php

namespace App\Repository\Order;

use App\Entity\Order;
use App\Entity\OrderLine;

interface OrderRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): ?Order;
  public function createOrder(): int;
  public function upsertOrderLine(Order $order, OrderLine $line): void;
  public function removeOrderLine(OrderLine $line): void;
}