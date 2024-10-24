<?php

namespace App\DTO;

use App\Entity\User;

class UserDTO
{
  public ?int $id;
  public ?string $firstname;
  public ?string $lastname;
  public ?string $email;
  public ?string $password;

  public function __construct(?int $id, ?string $firstname, ?string $lastname, ?string $email, ?string $password = null)
  {
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;

    if(!is_null($password)) {
      $this->password = $password;
    }
  }

  public static function mapFromUser(User $user): self
  {
    if(is_null($user)) {
      throw new \InvalidArgumentException("`mapFromUser`: param 'user' should not be null.");
    }

    return new self(
      $user->getId(),
      $user->getFirstname(),
      $user->getLastname(),
      $user->getEmail()
    );
  }

  public static function mapToUser(self $dto): User
  {
    if(is_null($dto)) {
      throw new \InvalidArgumentException("`toUser`: param 'dto' should not be null.");
    }

    $user = new User();
    $user->setEmail($dto->email);
    $user->setFirstname($dto->firstname);
    $user->setLastname($dto->lastname);
    $user->setPassword($dto->password);

    return $user;
  }
}
