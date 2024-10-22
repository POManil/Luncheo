<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Repository\User\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
  private $repository;

  public function __construct(UserRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function getAll(): JsonResponse
  {
    $userEntities = $this->repository->getAll();
    $userDtos = array_map(fn($user) => UserDTO::mapFromUser($user), $userEntities);

    return new JsonResponse(['users' => $userDtos]);
  }

  public function getUserById(int $id): JsonResponse
  {
    $user = UserDTO::mapFromUser($this->repository->getById($id));

    return new JsonResponse($user);
  }
}
