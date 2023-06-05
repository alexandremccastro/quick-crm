<?php

namespace Core\Validation;

use Core\Exceptions\ValidationException;
use Core\Validation\Builder;

abstract class Validation
{
  public function __construct(
    protected array $data
  ) {
  }

  public abstract function rules(): array;

  public function builder(): Builder
  {
    return new Builder();
  }

  public function validate()
  {
    $rules = $this->rules();

    $errors = [];
    $validated = [];

    // validate data
    foreach ($this->data as $key => $value) {
      if (isset($rules[$key])) {
        $value2 = $value;
        $result = $rules[$key]->validate($value2);

        if (count($result) > 0)
          $errors[$key] = $result;

        $validated[$key] = $value2;
      }
    }

    foreach ($errors as $error) {
      if (count($error)) throw new ValidationException($errors);
    }

    return $validated;
  }
}
