<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

use App\DTO\OrderDTO;
use App\DTO\OrderLineDTO;
use App\Repository\Order\OrderRepositoryInterface;
use App\Validation\ConstraintValidator;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
  private $repository;
  private $validator;
  private $serializer;
  private $logger;

  public function __construct (
    OrderRepositoryInterface $repository,
    ValidatorInterface $validator, 
    SerializerInterface $serializer,
    LoggerInterface $logger
  )
  {
    $this->repository = $repository;
    $this->validator = $validator;
    $this->serializer = $serializer;
    $this->logger = $logger;
  }

  public function getAll(): JsonResponse
  {
    try {
      $orderEntities = $this->repository->getAll();
      $orderDtos = array_map(fn($order) => OrderDTO::mapFromOrder($order), $orderEntities);
      // $orderDtos = [];

      // foreach($orderEntities as $order) {
      //   $orderDto = OrderDTO::mapFromOrder($order);
      //   $orderLinesDto = [];
      //   foreach($order->getLines() as $line) {
      //     $lineDto = OrderLineDTO::mapFromOrderLine($line);
      //     $orderLinesDto[] = $lineDto;
      //   }
      //   $orderDto->lines = $orderLinesDto;
      //   $orderDtos[] = $orderDto;
      // }

      return new JsonResponse(['Orders' => $orderDtos]);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function createOrder(#[MapRequestPayload] OrderDTO $dto): JsonResponse
  {
    try {
      $order = OrderDTO::mapToOrder($dto);

      $errors = $this->validator->validate($order);
      $messages = ConstraintValidator::handleViolationErrors($errors);

      if(count($errors) > 0) {
        return new JsonResponse(['validation' => $messages], 400);
      }

      return new JsonResponse(["message" => "La commande a bien été créée!"], 201);
    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }

  public function addOrderLine(mixed $request): JsonResponse 
  {
    return new JsonResponse('not yet implemented', 200);
  }
}
