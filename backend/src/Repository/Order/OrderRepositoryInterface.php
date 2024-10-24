<?php

namespace App\Repository\Order;

use App\Entity\Order;
use App\Entity\OrderLine;

interface OrderRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): ?Order;
  public function getByUserId(int $userId): array;
  public function createOrder(): int;
  public function updateOrder(Order $order): void;
  public function upsertOrderLine(Order $order, OrderLine $line): void;
  public function removeOrderLine(Order $order, OrderLine $line): void;
  public function removeOrder(Order $order): void;
}