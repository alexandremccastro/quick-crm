<?php

namespace Core\Validation;

use DateTime;
use Exception;

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

  public function min(int $min)
  {
    $this->rules[] = new Rule("Must have at least $min characters", function (string $value) use ($min) {
      return strlen($value) >= $min;
    }, true);

    return $this;
  }

  public function minCount(int $min)
  {
    $this->rules[] = new Rule("Must have at least $min elements", function (array $elements) use ($min) {
      return count($elements) >= $min;
    }, true);

    return $this;
  }

  public function max(int $max)
  {
    $this->rules[] = new Rule("Must have the maximum of $max characters", function ($value) use ($max) {
      return strlen($value) <= $max;
    }, true);

    return $this;
  }

  public function maxCount(int $max)
  {
    $this->rules[] = new Rule("Must have at least $max elements", function (array $elements) use ($max) {
      return count($elements) <= $max;
    }, true);

    return $this;
  }

  public function length(int $length)
  {
    $this->rules[] = new Rule("Must have $length characters", function (string $value) use ($length) {
      return strlen($value) == $length;
    }, true);

    return $this;
  }

  public function array()
  {
    $this->rules[] = new Rule("Must be an array", 'is_array', true);

    return $this;
  }

  public function date(string $format = 'Y-m-d')
  {
    $this->rules[] = new Rule("Must be a valid date", function (string $date) use ($format) {
      return DateTime::createFromFormat($format, $date);
    }, true);

    return $this;
  }

  public function customRule(Rule $rule)
  {
    $this->rules[] = $rule;

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
