<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\Order\OrderRepositoryInterface;

#[ORM\Entity(repositoryClass: OrderRepositoryInterface::class)]
#[ORM\Table(name: '`order`')]
class Order
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private ?int $id = null;

  #[ORM\Column(type: 'datetime')]
  #[Assert\NotNull]
  private \DateTime $orderDate;

  #[ORM\Column(type: 'boolean')]
  private bool $isPaid = false;

  #[ORM\OneToMany(targetEntity: OrderLine::class)]
  private array $lines;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getOrderDate(): \DateTime
  {
    return $this->orderDate;
  }

  public function setOrderDate(\DateTime $orderDate): void
  {
    $this->orderDate = $orderDate;
  }

  public function isPaid(): bool
  {
    return $this->isPaid;
  }

  public function setPaid(bool $isPaid): void
  {
    $this->isPaid = $isPaid;
  }

  public function getLines(): array
  {
    return $this->lines;
  }

  public function addLine(OrderLine $line): void
  {
    $this->lines[] = $line;
  }
}
