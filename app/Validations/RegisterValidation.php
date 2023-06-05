<?php

namespace App\Validations;

use App\Models\User;
use Core\Validation\Rule;
use Core\Validation\Validation;

class RegisterValidation extends Validation
{
  public function __construct(array $data)
  {
    parent::__construct($data);
  }

  public function rules(): array
  {
    return [
      'name' => $this->builder()->required()->string(),
      'email' => $this->builder()->required()->string()->email()->customRule($this->emailMustBeUnique()),
      'password' => $this->builder()->required()->string()
    ];
  }


  public function emailMustBeUnique(): Rule
  {
    return new Rule('Email already exists', function ($email) {
      $userModel = new User();
      $found = $userModel->findOne(['email', '=', $email]);

      return $found == null;
    }, true);
  }
}
