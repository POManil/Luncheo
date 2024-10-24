<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;

use App\DTO\OrderDTO;
use App\DTO\OrderLineDTO;
use App\DTO\PaymentDTO;
use App\DTO\UserDTO;
use App\Validation\ConstraintValidator;
use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\OrderLine\OrderLineRepositoryInterface;
use App\Repository\Sandwich\SandwichRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;

class OrderController extends AbstractController
{
  private $orderRepository;
  private $userRepository;
  private $sandwichRepository;
  private $orderLineRepository;
  private $validator;
  private $serializer;
  private $logger;

  public function __construct (
    OrderRepositoryInterface $orderRepository,
    UserRepositoryInterface $userRepository,
    SandwichRepositoryInterface $sandwichRepository,
    OrderLineRepositoryInterface $orderLineRepository,
    ValidatorInterface $validator, 
    SerializerInterface $serializer,
    LoggerInterface $logger
  )
  {
    $this->orderRepository = $orderRepository;
    $this->userRepository = $userRepository;
    $this->sandwichRepository = $sandwichRepository;
    $this->orderLineRepository = $orderLineRepository;
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

  public function getByUserId(string $userId): JsonResponse
  {
    if(!is_numeric($userId)) {
      return new JsonResponse(["validation" => "L'identifiant de l'utilisateur doit être un entier positif."], 400);
    }
    
    try {
      $userEntity = $this->userRepository->getById((int)$userId);
      if(is_null($userEntity)) {
        return new JsonResponse(["message" => "Utilisateur non-trouvé"], 404);
      }

      $orderEntities = $this->orderRepository->getByUserId((int)$userId);
      $orderDtos = array_map(fn($order) => OrderDTO::mapFromOrder($order), $orderEntities);

      return new JsonResponse(["user" => UserDTO::mapFromUser($userEntity), "orders" => $orderDtos], 200);

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

  public function payOrder(#[MapRequestPayload] PaymentDTO $payment): JsonResponse
  {
    if(!$payment->isPaymentValid) {
      return new JsonResponse(["message" => "Le paiement a été refusé."], 400);
    }

    if(!is_numeric($payment->orderId)) {
      return new JsonResponse(["validation" => "L'identifiant de la commande doit être un entier positif."], 400);
    }

    try {
      $orderEntity = $this->orderRepository->getById($payment->orderId);
      $orderEntity->setPaid($payment->isPaymentValid);
      $this->orderRepository->updateOrder($orderEntity);

      return new JsonResponse(200);      
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function upsertOrderLine(#[MapRequestPayload] OrderLineDTO $dto): JsonResponse 
  {
    if(!is_numeric($dto->orderId) || !is_numeric($dto->userId) || !is_numeric($dto->sandwichId) || !is_numeric($dto->quantity)) {
      return new JsonResponse(["validation" => "Les paramètres doivent être des nombres entiers"], 400);
    }

    try {
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

      $this->orderRepository->upsertOrderLine($orderEntity, $orderLineEntity);

      return new JsonResponse('La commande du sandwich ' .$sandwichEntity->getLabel() . ' a bien été passée.', 200);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function removeOrder(string $id): JsonResponse
  {    
    if(!is_numeric($id)){
      return new JsonResponse(["validation" => "L'identifiant de la commande doit être un nombre entier"], 400);
    }
    try {
      $orderEntity = $this->orderRepository->getById((int)$id);
      if(is_null($orderEntity)) {
        return new JsonResponse(["message" => "Commande non-trouvée"], 404);
      }

      $this->orderRepository->removeOrder($orderEntity);

      return new JsonResponse(200);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function removeOrderLine(Request $request): JsonResponse
  {
    $orderId = $request->query->get('orderId');
    $userId = $request->query->get('userId');
    $sandwichId = $request->query->get('sandwichId');

    if(!is_numeric($orderId) || !is_numeric($userId) || !is_numeric($sandwichId)) {
      return new JsonResponse(["validation" => "Les paramètres doivent être des nombres entiers"], 400);
    }

    try {
      $orderEntity = $this->orderRepository->getById($orderId);
      if(is_null($orderEntity)) {
        return new JsonResponse(["message" => "Commande non-trouvée"], 404);
      }

      $userEntity = $this->userRepository->getById($userId);
      if(is_null($userEntity)) {
        return new JsonResponse(["message" => "Utilisateur non-trouvé"], 404);
      }

      $sandwichEntity = $this->sandwichRepository->getById($sandwichId);
      if(is_null($sandwichEntity)) {
        return new JsonResponse(["message" => "Sandwich non-trouvé"], 404);
      }
      
      $orderLineEntity = $this->orderLineRepository->getById($orderId, $userId, $sandwichId);

      $this->orderRepository->removeOrderLine($orderEntity, $orderLineEntity);

      return new JsonResponse('La commande de '. $orderLineEntity->getQuantity(). ' sandwich ' .$sandwichEntity->getLabel() . ' a bien été supprimée.', 200);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }
}
