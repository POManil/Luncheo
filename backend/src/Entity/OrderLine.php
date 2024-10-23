<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
// use App\Repository\OrderLineRepository;

// #[ORM\Entity(repositoryClass: OrderLineRepository::class)]
class OrderLine
{
  #[ORM\Id]
  #[ORM\ManyToOne(targetEntity: Order::class)]
  #[ORM\JoinColumn(nullable: false)]
  private Order $order;

  #[ORM\Id]
  #[ORM\ManyToOne(targetEntity: User::class)]
  #[ORM\JoinColumn(nullable: false)]
  private User $user;

  // #[ORM\Id]
  // #[ORM\ManyToOne(targetEntity: Sandwich::class)]
  // #[ORM\JoinColumn(nullable: false)]
  // private Sandwich $sandwich;

  #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
  private float $price;

  #[ORM\Column(type: 'integer')]
  private int $quantity;

  public function getOrder(): Order
  {
    return $this->order;
  }

  public function getUser(): User
  {
    return $this->user;
  }

  // public function getSandwich(): Sandwich
  // {
  //   return $this->sandwich;
  // }

  public function getPrice(): float
  {
    return $this->price;
  }

  public function setPrice(float $price): void
  {
    $this->price = $price;
  }

  public function getQuantity(): int
  {
    return $this->quantity;
  }

  public function setQuantity(int $quantity): void
  {
    $this->quantity = $quantity;
  }
}
