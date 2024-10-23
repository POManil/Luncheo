<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

use App\DTO\OrderDTO;
use App\DTO\OrderLineDTO;
use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\Sandwich\SandwichRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use App\Validation\ConstraintValidator;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
  private $orderRepository;
  private $userRepository;
  private $sandwichRepository;
  private $validator;
  private $serializer;
  private $logger;

  public function __construct (
    OrderRepositoryInterface $orderRepository,
    UserRepositoryInterface $userRepository,
    SandwichRepositoryInterface $sandwichRepository,
    ValidatorInterface $validator, 
    SerializerInterface $serializer,
    LoggerInterface $logger
  )
  {
    $this->orderRepository = $orderRepository;
    $this->userRepository = $userRepository;
    $this->sandwichRepository = $sandwichRepository;
    $this->validator = $validator;
    $this->serializer = $serializer;
    $this->logger = $logger;
  }

  public function getAll(): JsonResponse
  {
    try {
      $orderEntities = $this->orderRepository->getAll();
      $orderDtos = array_map(fn($order) => OrderDTO::mapFromOrder($order), $orderEntities);

      return new JsonResponse($orderDtos);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function createOrder(): JsonResponse
  {
    try {
      $orderId = $this->orderRepository->createOrder();

      return new JsonResponse(["message" => "La commande a bien été créée!", "orderId" => $orderId], 201);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function addOrderLine(#[MapRequestPayload] OrderLineDTO $dto): JsonResponse 
  {
    try {

      dump($dto);

      $orderEntity = $this->orderRepository->getById($dto->orderId);
      if(is_null($orderEntity)) {
        return new JsonResponse(["message" => "Commande non-trouvée"], 404);
      }

      $userEntity = $this->userRepository->getById($dto->userId);
      if(is_null($userEntity)) {
        return new JsonResponse(["message" => "Utilisateur non-trouvé"], 404);
      }

      $sandwichEntity = $this->sandwichRepository->getById($dto->sandwichId);
      if(is_null($sandwichEntity)) {
        return new JsonResponse(["message" => "Sandwich non-trouvé"], 404);
      }

      dump("jusqu'ici tout va bien");
      dump("order entity");
      dump($orderEntity);
      dump("user entity");
      dump($userEntity);
      dump("sandwich entity");
      dump($sandwichEntity);

      $orderLineEntity = OrderLineDTO::mapToOrderLine(
        $dto, 
        $sandwichEntity,
        $orderEntity,
        $userEntity
      );

      $errors = $this->validator->validate($orderLineEntity);
      $messages = ConstraintValidator::handleViolationErrors($errors);

      if(count($errors) > 0) {
        return new JsonResponse(['validation' => $messages], 400);
      }  

      $this->orderRepository->addOrderLine($orderEntity, $orderLineEntity);

      return new JsonResponse('La commande du sandwich ' .$sandwichEntity->getLabel() . ' a bien été passée.', 200);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }
}
