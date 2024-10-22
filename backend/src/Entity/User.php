<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\User\UserRepositoryInterface;
use App\Validation\UserValidator;

#[ORM\Entity(repositoryClass: UserRepositoryInterface::class)]
#[ORM\Table(name: '`user`')]
class User
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private ?int $id = null;

  #[ORM\Column(type: 'string')]
  #[Assert\NotBlank]
  #[Assert\Length(min: 2)]
  #[Assert\Regex(pattern: UserValidator::NAME_REGEX, message: UserValidator::FIRSTNAME_MESSAGE)]
  private string $firstname;

  #[ORM\Column(type: 'string')]
  #[Assert\NotBlank]
  #[Assert\Length(min: 2)]
  #[Assert\Regex(pattern: UserValidator::NAME_REGEX, message: UserValidator::LASTNAME_MESSAGE)]
  private string $lastname;

  #[ORM\Column(type: 'string', unique: 'true')]
  #[Assert\NotBlank]
  #[Assert\Regex(pattern: UserValidator::EMAIL_REGEX, message: UserValidator::EMAIL_MESSAGE)]
  private string $email;

  #[ORM\Column(type: 'string', name: '`password`')]
  #[Assert\NotBlank]
  #[Assert\Length(min: 6)]
  #[Assert\Regex(pattern: UserValidator::PASSWORD_REGEX, message: UserValidator::PASSWORD_MESSAGE)]
  private string $password;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getFirstname(): string
  {
    return $this->firstname;
  }

  public function setFirstname(string $value): void
  {
    $this->firstname = $value;
  }

  public function getLastname(): string
  {
    return $this->lastname;
  }

  public function setLastname(string $value): void
  {
    $this->lastname = $value;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setEmail(string $value): void
  {
    $this->email = $value;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword(string $value): void
  {
    $this->password = $value;
  }
}
