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
        $sanitizedValue = is_string($value) ? trim($value) : $value;
        $result = $rules[$key]->validate($sanitizedValue);

        if (count($result) > 0)
          $errors[$key] = $result;

        $validated[$key] = $sanitizedValue;
      }
    }

    foreach ($errors as $error) {
      if (count($error)) throw new ValidationException($errors);
    }

    return $validated;
  }
}
