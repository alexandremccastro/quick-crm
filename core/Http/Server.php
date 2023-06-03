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

  /**
   * @return string The document root of index.php file
   */
  public static function documentRoot()
  {
    return $_SERVER['DOCUMENT_ROOT'];
  }
}
