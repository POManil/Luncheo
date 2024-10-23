<?php

namespace App\Repository\Order;

use App\Entity\Order;
use App\Entity\OrderLine;

interface OrderRepositoryInterface
{
  public function getAll(): array;
  public function createOrder(Order $order): int;
  public function addOrderLine(Order $order, OrderLine $line): void;
  public function removeOrderLine(OrderLine $line): void;
}