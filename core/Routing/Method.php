<?php

namespace Core\Routing;

enum Method
{
  case GET;
  case POST;
  case PUT;
  case PATCH;
  case DELETE;

  public function value(): string
  {
    return match ($this) {
      self::GET => 'GET',
      self::POST => 'POST',
      self::PUT => 'PUT',
      self::PATCH => 'PATCH',
      self::DELETE => 'DELETE'
    };
  }
}
