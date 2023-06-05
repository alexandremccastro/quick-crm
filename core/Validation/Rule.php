<?php

namespace Core\Validation;

class Rule
{
  public function __construct(
    private string $message,
    private mixed $validator,
    private bool $useCallback = false
  ) {
  }

  public function execute(&$value)
  {
    if ($this->useCallback) {
      return call_user_func_array($this->validator, [&$value]);
    } else {
      return filter_var($value, $this->validator);
    }
  }

  public function getMessage()
  {
    return $this->message;
  }
}
