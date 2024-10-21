<?php

namespace App\Example\Application\GetAllExamples\Handler;

use App\Example\Application\GetAllExamples\Query\GetAllExamplesQuery;
use App\Example\Domain\Repository\ExampleRepositoryInterface;

class GetAllExamplesHandler
{
    private ExampleRepositoryInterface $repository;

    public function __construct(ExampleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetAllExamplesQuery $query): array
    {
        return $this->repository->getAll();
    }
}
