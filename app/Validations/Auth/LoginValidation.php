<?php

namespace App\Validations\Auth;

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
      'email' => $this->builder()->required()->string()->email()->max(100)->trim(),
      'password' => $this->builder()->required()->string()->min(4)->max(100)
    ];
  }
}
