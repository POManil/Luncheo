<?php

namespace App\Repository\Sandwich;

use App\Entity\Sandwich;

interface SandwichRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): ?Sandwich;
}