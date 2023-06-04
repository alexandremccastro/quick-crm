<?php

namespace Core\View;

final class View
{
  public static function load(string $path, array $params = [])
  {
    foreach ($params as $key => $param) {
      $$key = $param;
    }

    $content = Loader::render($path);

    return response()->setContent($content)
      ->withHeaders(["Content-Type: text/html"]);
  }
}
