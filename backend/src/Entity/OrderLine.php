<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Sandwich;
use App\Validation\Rules\CommonRules;

#[ORM\Entity]
class OrderLine
{
  #[ORM\Id]
  #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'lines')]
  #[ORM\JoinColumn(nullable: false)]
  private Order $order;

  #[ORM\Id]
  #[ORM\ManyToOne(targetEntity: User::class)]
  #[ORM\JoinColumn(nullable: false)]
  private User $user;

  #[ORM\Id]
  #[ORM\ManyToOne(targetEntity: Sandwich::class)]
  #[ORM\JoinColumn(nullable: false)]
  private Sandwich $sandwich;

  #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
  #[Assert\GreaterThanOrEqual(value: .0, message: CommonRules::NOT_NEGATIVE_MESSAGE)]
  private float $price;

  #[ORM\Column(type: 'integer')]
  #[Assert\GreaterThanOrEqual(value: 0, message: CommonRules::NOT_NEGATIVE_MESSAGE)]
  private int $quantity;

  public function __construct(Order $order, Sandwich $sandwich, User $user, int $quantity = 1)
  {
    $this->order = $order;
    $this->sandwich = $sandwich;
    $this->user = $user;

    $this->quantity = $quantity;
    $this->price = $quantity * $sandwich->getUnitPrice();
  }

  public function getOrder(): Order
  {
    return $this->order;
  }

  public function setOrder(Order $order): void
  {
    $this->order = $order;
  }

  public function getUser(): User
  {
    return $this->user;
  }

  public function setUser(User $user): void
  {
    $this->user = $user;
  }

  public function setSandwich(Sandwich $sandwich): void
  {
    $this->sandwich = $sandwich;
  }

  public function getSandwich(): Sandwich
  {
    return $this->sandwich;
  }

  public function getPrice(): float
  {
    return $this->price;
  }

  public function getQuantity(): int
  {
    return $this->quantity;
  }

  public function setQuantity(int $quantity): void
  {
    $this->quantity = $quantity;
    $this->price = $quantity * $this->sandwich->getUnitPrice();
  }
}
