<?php

namespace App\Validation\Rules;

abstract class OrderLineRules
{
  public const LABEL_REGEX = '/^[A-Z][a-zA-Z]+$/';
  public const LABEL_REGEX_MESSAGE = 'Le libellé commencer par une majuscule et comporter au moins 2 lettres.';
}