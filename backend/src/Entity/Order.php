<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\Order\OrderRepositoryInterface;
use DateTime;

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

  #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'order', orphanRemoval: true)]
  private Collection $lines;

  public function __construct()
  {
    $this->lines = new ArrayCollection();
  }

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

  public function getLines(): Collection
  {
    return $this->lines;
  }

  public function upsertLine(OrderLine $line): void
  {
    $this->lines[] = $line;
    $line->setOrder($this);
  }

  public function removeLine(OrderLine $line): void
  {
    if ($this->lines->contains($line)) {
      $this->lines->removeElement($line);
    }
  }
}
