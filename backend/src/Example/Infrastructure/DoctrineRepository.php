<?php

namespace App\Example\Infrastructure\DoctrineRepository;

use App\Example\Domain\Repository\ExampleRepositoryInterface;
use App\Example\Infrastructure\DoctrineEntity\Example;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExampleRepository extends ServiceEntityRepository implements ExampleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Example::class);
    }
    
    public function getAll(): array
    {
        return $this->createQueryBuilder('e')->select('e.id', 'e.name')->getQuery()->getResult();
    }
}
