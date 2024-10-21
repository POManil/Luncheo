<?php

namespace App\Example\API\Controller;

use App\Example\Domain\Repository\ExampleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExampleController extends AbstractController
{
  public function helloWorld(): JsonResponse
  {
    return new JsonResponse(['message' => 'Hello, world!']);
  }

  public function getAll(ExampleRepositoryInterface $repository): JsonResponse
  {    
    return new JsonResponse(['data' => $repository->getAll()]);
  }
}