<?php

namespace Core\Validation;

use Core\Exceptions\ValidationException;
use Core\Validation\Builder;

abstract class Validation
{

  public abstract function rules(): mixed;

  public function builder(): Builder
  {
    return new Builder();
  }

  public function validate(array $data)
  {
    $rules = $this->rules();

    $errors = [];
    $validated = [];

    // validate data
    foreach ($data as $key => $value) {
      if (isset($rules[$key])) {
        $errors[$key] = $rules[$key]->validate($value);
        $validated[$key] = $value;
      }
    }

    foreach ($errors as $error) {
      if (count($error)) throw new ValidationException($errors);
    }

    return $validated;
  }
}
