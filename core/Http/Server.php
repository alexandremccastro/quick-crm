<?php

namespace Core\Http;

use Core\Traits\Singletron;

final class Server
{
  use Singletron;

  public static function setRequestMethod($method)
  {
    $_SERVER['REQUEST_METHOD'] = $method;
  }

  /**
   * @return string The current method of the request
   */
  public static function getRequestMethod()
  {
    if (isset($_REQUEST['method'])) return $_REQUEST['method'];
    else return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * @return string The document root of index.php file
   */
  public static function getDocumentRoot()
  {
    return $_SERVER['DOCUMENT_ROOT'];
  }
}
