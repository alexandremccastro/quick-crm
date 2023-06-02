<?php

namespace Core\Http;

use Core\Traits\Singletron;

final class Server
{
  use Singletron;

  /**
   * @return string The current method of the request
   */
  public static function requestMethod()
  {
    return $_SERVER['REQUEST_METHOD'];
  }
}
