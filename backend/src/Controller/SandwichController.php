<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

use App\DTO\SandwichDTO;
use App\Repository\Sandwich\SandwichRepositoryInterface;

class SandwichController extends AbstractController
{
  private $sandwichRepository;
  private $logger;

  public function __construct (
    SandwichRepositoryInterface $sandwichRepository,
    LoggerInterface $logger
  )
  {
    $this->sandwichRepository = $sandwichRepository;
    $this->logger = $logger;
  }

  public function getAll(): JsonResponse
  {
    try {
      $sandwiches = $this->sandwichRepository->getAll();
      $sandwichDtos = array_map(fn($sandwich) => SandwichDTO::mapFromSandwich($sandwich), $sandwiches);

      return new JsonResponse($sandwichDtos, 200);

    } catch (\Exception $e) {
      $this->logger->error($e);

      return new JsonResponse(["message" => "Une erreur imprévue est survenue"], 500);
    }
  }
}