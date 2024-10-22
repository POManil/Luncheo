<?php

namespace App\Controller;

use App\Repository\ExampleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExampleController extends AbstractController
{
  private $repository;

  public function __construct(ExampleRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }

  public function helloWorld(): JsonResponse
  {
    return new JsonResponse(['message' => 'Hello, world!']);
  }
  public function getAll(): JsonResponse
  {
    return new JsonResponse(['data' => $this->repository->getAll()]);
  }
}
