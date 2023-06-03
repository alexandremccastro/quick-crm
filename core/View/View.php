<?php

namespace Core\View;

final class View
{
  public static function load(string $path, array $params = [])
  {
    foreach ($params as $key => $param) {
      $$key = $param;
    }

    Loader::render($path);
  }
}
