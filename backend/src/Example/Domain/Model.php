<?php 

namespace App\Example\Domain\Model;

class Example
{
    private ?int $id = null;
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
