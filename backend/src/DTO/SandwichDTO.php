<?php

namespace App\DTO;

use App\Entity\Sandwich;

class SandwichDTO
{
  public ?int $id;
  public ?string $label;
  public ?float $unitPrice;

  public function __construct(?int $id, ?string $label, ?float $unitPrice)
  {
    $this->id = $id;
    $this->label = $label;
    $this->unitPrice = $unitPrice;
  }

  public static function mapFromSandwich(Sandwich $sandwich): self
  {
    if(is_null($sandwich)) {
      throw new \InvalidArgumentException("`mapFromSandwich`: param 'sandwich' should not be null.");
    }

    return new self (
      $sandwich->getId(),
      $sandwich->getLabel(),
      $sandwich->getUnitPrice()
    );
  }

  public static function mapToSandwich(self $dto): Sandwich
  {
    if(is_null($dto)) {
      throw new \InvalidArgumentException("`mapToSandwich`: param 'dto' should not be null.");
    }

    $sandwich = new Sandwich();
    $sandwich->setUnitPrice($dto->unitPrice);
    $sandwich->setLabel($dto->label);

    return $sandwich;
  }
}