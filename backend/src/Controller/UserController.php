<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Exception as DBALException;

use App\DTO\UserDTO;
use App\Repository\User\UserRepositoryInterface;

class UserController extends AbstractController
{
  private $repository;
  private $logger;

  public function __construct(UserRepositoryInterface $repository, LoggerInterface $logger)
  {
    $this->repository = $repository;
    $this->logger = $logger;
  }

  public function getAll(): JsonResponse
  {
    try {
      $userEntities = $this->repository->getAll();
      $userDtos = array_map(fn($user) => UserDTO::mapFromUser($user), $userEntities);

      return new JsonResponse(['users' => $userDtos]);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur impréveu est survenue"], 500);
    }
  }

  public function getUserById(int $id): JsonResponse
  {
    try {
      $userEntity = $this->repository->getById($id);

      if (empty($userEntity)) {
        return new JsonResponse(["message" => "User not found."], 404);
      }

      $userDto = UserDTO::mapFromUser($this->repository->getById($id));
      return new JsonResponse($userDto);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur impréveu est survenue"], 500);
    }
  }
}
