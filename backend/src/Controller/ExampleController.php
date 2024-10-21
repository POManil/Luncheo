<?php

namespace App\Controller;

use App\Repository\ExampleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExampleController extends AbstractController
{
  public function helloWorld(): JsonResponse
  {
    return new JsonResponse(['message' => 'Hello, world!']);
  }

  public function getAll(ExampleRepository $repository): JsonResponse
  {    
    return new JsonResponse(['data' => $repository->getAll()]);
  }
}