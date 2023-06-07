<?php

namespace Core\View;

final class View
{
  public static function load(string $path, array $params = [])
  {
    $content = Loader::render($path, $params);


    return response()->setContent($content)->with($params)
      ->withHeaders(["Content-Type: text/html"]);
  }
}
