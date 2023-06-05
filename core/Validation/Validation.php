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
    foreach ($rules as $key => $rule) {
      $value = null;

      if (isset($this->data[$key]))
        $value = $this->data[$key];

      $result = $rule->validate($value);

      if (count($result) > 0)
        $errors[$key] = $result;

      $validated[$key] = $value;
    }

    foreach ($errors as $error) {
      if (count($error)) throw new ValidationException($errors);
    }

    return $validated;
  }
}
