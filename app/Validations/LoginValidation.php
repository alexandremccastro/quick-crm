<?php

namespace App\Validations;

use Core\Validation\Validation;

class LoginValidation extends Validation
{
  public function __construct(array $data)
  {
    parent::__construct($data);
  }

  public function rules(): array
  {
    return [
      'email' => $this->builder()->required()->string()->email(),
      'password' => $this->builder()->required()->string()
    ];
  }
}
