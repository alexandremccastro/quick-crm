<?php

namespace Core\Exceptions;

use \Exception;

class ValidationException extends Exception
{
  private array $errors = [];

  public function __construct(array $errors)
  {
    parent::__construct('Invalid parameters.', 403);
    $this->errors = $errors;
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
