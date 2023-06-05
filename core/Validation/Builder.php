<?php

namespace Core\Validation;

class Builder
{

  private $rules = [];

  public function required()
  {
    $this->rules[] = new Rule('This field is required', function ($value) {
      if (empty($value)) return false;
      else return true;
    }, true);

    return $this;
  }

  public function email()
  {
    $this->rules[] = new Rule('Must be a valid email', FILTER_VALIDATE_EMAIL);

    return $this;
  }


  public function int()
  {
    $this->rules[] = new Rule('Must be an integer', FILTER_VALIDATE_INT);

    return $this;
  }

  public function string()
  {
    $this->rules[] = new Rule('Must be a string', 'is_string', true);

    return $this;
  }

  public function validate($value)
  {
    $errors = [];

    foreach ($this->rules as $rule) {
      if (!$rule->execute($value)) {
        $errors[] = $rule->getMessage();
      }
    }

    return $errors;
  }
}
