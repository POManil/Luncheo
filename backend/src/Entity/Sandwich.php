<?php

namespace App\Entity;

use App\Validation\Rules\CommonRules;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Validation\Rules\SandwichRules;

#[ORM\Entity]
class Sandwich
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private ?int $id = null;

  #[ORM\Column(type: 'string')]
  #[Assert\Regex(pattern: SandwichRules::LABEL_REGEX, message: SandwichRules::LABEL_REGEX_MESSAGE)]
  private string $label;
  
  #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
  #[Assert\GreaterThanOrEqual(value: .0, message: CommonRules::NOT_NEGATIVE_MESSAGE)]
  private float $unitPrice;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getLabel(): string
  {
    return $this->label;
  }

  public function setLabel(string $value): void
  {
    $this->label = $value;
  }

  public function getUnitPrice(): float
  {
    return $this->unitPrice;
  }

  public function setUnitPrice(float $value): void
  {
    if($value >= .0) {
      $this->unitPrice = $value;
    } else {
      $this->unitPrice = .0;
    }
  }
}
