<?php

namespace App\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintValidator 
{
  static function handleViolationErrors(ConstraintViolationListInterface $violations): array
  {
    $errorMessages = [];

    foreach ($violations as $violation) {
      $errorMessages[] = [$violation->getPropertyPath() => $violation->getMessage()];
    }

    return $errorMessages;
  }
}