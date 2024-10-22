<?php

namespace App\Repository\User;

use App\Entity\User;

interface UserRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): User;
}

