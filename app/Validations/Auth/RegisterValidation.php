<?php

namespace App\Validations\Auth;

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
      'name' => $this->builder()->required()->string()->min(2)->max(100)->trim(),
      'email' => $this->builder()->required()->string()
        ->email()->customRule($this->emailMustBeUnique())->max(100)->trim(),
      'password' => $this->builder()->required()->string()->max(100)->min(4)
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
