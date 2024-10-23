<?php

namespace App\Repository\User;

use App\Entity\User;

interface UserRepositoryInterface
{
  public function getAll(): array;
  public function getById(int $id): ?User;
  public function getByEmail(string $email): ?User;
  public function createUser(User $user): int;
  public function login (string $email, string $password): ?User;
}

