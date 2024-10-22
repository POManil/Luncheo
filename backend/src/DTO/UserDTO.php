<?php

namespace App\DTO;

use App\Entity\User;

class UserDTO
{
  public int $id;
  public string $firstname;
  public string $lastname;
  public string $email;

  private function __construct(int $id, string $firstname, string $lastname, string $email)
  {
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;
  }

  public static function mapFromUser(User $user): self
  {
    return new self(
      $user->getId(),
      $user->getFirstname(),
      $user->getLastname(),
      $user->getEmail()
    );
  }
}
