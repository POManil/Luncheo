<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

use App\DTO\OrderDTO;
use App\Repository\Order\OrderRepositoryInterface;

class OrderController extends AbstractController
{
  private $repository;
  private $logger;

  public function __construct (
    OrderRepositoryInterface $repository, 
    LoggerInterface $logger
  )
  {
    $this->repository = $repository;
    $this->logger = $logger;
  }

  public function getAll(): JsonResponse
  {
    try {
      $orderEntities = $this->repository->getAll();
      $orderDtos = array_map(fn($order) => OrderDTO::mapFromOrder($order), $orderEntities);

      return new JsonResponse(['Orders' => $orderDtos]);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }
}
