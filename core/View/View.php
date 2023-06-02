<?php

namespace Core\View;

abstract class View
{

  private static $path = 'resources/views';

  public static function load(string $path, array $params = [])
  {
    $filePath = explode('.', $path);

    foreach ($params as $key => $param) {
      $$key = $param;
    }

    include_once implode(DIRECTORY_SEPARATOR, [self::$path, ...$filePath]) . '.php';
  }
}
