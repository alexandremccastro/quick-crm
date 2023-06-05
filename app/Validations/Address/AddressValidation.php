<?php

namespace App\Validations\Address;

use Core\Validation\Validation;

class AddressValidation extends Validation
{
  public function __construct(array $data)
  {
    parent::__construct($data);
  }

  public function rules(): array
  {
    return [
      'street' => $this->builder()->required()->string()->max(100)->trim(),
      'number' => $this->builder()->string()->max(20)->trim(),
      'zip_code' => $this->builder()->required()->string()->max(10)->onlyDigits()->trim(),
      'city' => $this->builder()->required()->string()->max(100)->trim(),
      'state' => $this->builder()->required()->string()->max(100),
      'country' => $this->builder()->required()->length(2)->string()
    ];
  }
}
