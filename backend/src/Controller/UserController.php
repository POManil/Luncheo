<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Repository\User\UserRepositoryInterface;
use App\Validation\UserValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
  private $repository;
  private $validator;
  private $logger;

  public function __construct(UserRepositoryInterface $repository, ValidatorInterface $validator, LoggerInterface $logger)
  {
    $this->repository = $repository;
    $this->validator = $validator;
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

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function getUserById(int $id): JsonResponse
  {
    try {
      $userEntity = $this->repository->getById($id);

      if (empty($userEntity)) {
        return new JsonResponse(["message" => "User not found."], 404);
      }

      $userDto = UserDTO::mapFromUser($userEntity);
      return new JsonResponse($userDto);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function register(#[MapRequestPayload] UserDTO $dto): JsonResponse
  {
    try {
      $user = UserDTO::mapToUser($dto);
      
      $errors = $this->validator->validate($user);
      $messages = UserValidator::handleViolationErrors($errors);

      if(count($errors) > 0) {
        return new JsonResponse(["validation" => $messages], 400);
      }

      $userWithSameEmail = $this->repository->getByEmail($user->getEmail());
      if(!is_null($userWithSameEmail)) {
        return new JsonResponse(["message" => "Cet email n'est pas disponible."], 400);
      }

      $insertionResult = $this->repository->createUser($user);
      $this->logger->info($insertionResult);

      return new JsonResponse(["message" => "Votre compte a bien été créé!"]);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function login(#[MapRequestPayload] UserDTO $dto): JsonResponse
  {
    try {
      $userEntity = $this->repository->login($dto->email, $dto->password);

      if(is_null($userEntity)) {
        return new JsonResponse(["message" => "Mauvais login ou mot de passe."], 403);
      }

      return new JsonResponse(UserDTO::mapFromUser($userEntity));
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }
}
