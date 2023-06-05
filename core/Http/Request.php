<?php

namespace Core\Http;

use Core\Routing\Method;
use Core\Traits\Singletron;

final class Request
{
  use Singletron;

  /**
   * @return string The param found in post method
   */
  public static function post(string $key)
  {
    return $_POST[$key] ?? null;
  }

  public static function setData(array $data, Method $method)
  {
    switch ($method) {
      case Method::POST:
      case Method::PATCH:
      case Method::PATCH:
        $_POST = $data;
        break;
      case Method::GET:
        $_GET = $data;
        break;
    }
  }

  /**
   * @return string The param found in get method
   */
  public static function get(string $key)
  {
    return $_GET[$key] ?? null;
  }

  /**
   * 
   * @return array All items in the current request
   */
  public static function all()
  {
    return array_merge($_GET, $_POST);
  }
}
