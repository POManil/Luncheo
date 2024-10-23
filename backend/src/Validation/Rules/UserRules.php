<?php

namespace App\Validation\Rules;

abstract class UserRules
{
  public const NAME_REGEX = '/^[A-Z][a-zA-Z]+$/';
  public const FIRSTNAME_REGEX_MESSAGE = 'Le prénom doit commencer par une majuscule et comporter au moins 2 lettres.'; 
  public const LASTNAME_REGEX_MESSAGE = 'Le nom doit commencer par une majuscule et comporter au moins 2 lettres.';

  public const EMAIL_REGEX = '/^[^@]+@[^@]+\.[^@]+$/';
  public const EMAIL_MESSAGE = 'L\'email doit respecter le format "x@x.xx".';
  
  public const PASSWORD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
  public const PASSWORD_MESSAGE = 'Le mot de passe doit contenir au moins 6 caractères, dont une majuscule, une minuscule et un chiffre.';
}