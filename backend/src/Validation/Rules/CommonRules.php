<?php

namespace App\Validation\Rules;

abstract class CommonRules
{
  public const NOT_NULL_MESSAGE = 'Cette valeur ne peut pas être vide';
  public const NOT_NEGATIVE_MESSAGE = 'Cette valeur ne peut pas être négative.';
}