<?php

namespace Core\View;

final class Loader
{
  private static string $viewsDir = 'resources/views';

  /**
   * Renders a given view
   * 
   * @param $view The view to be rendered
   */
  public static function render(string $view, array $params = []): string
  {
    $viewData = self::loadView($view, $params);

    [$parent, $data] = self::getContent($viewData);

    if ($parent) {
      $parentData = self::loadView($parent);

      return preg_replace("/@child/", $data, $parentData);
    } else {
      return $data;
    }
  }

  /**
   * Loads a view content
   * 
   * @param $path The path/name of the view
   * 
   * @return string The view content
   */
  private static function loadView(string $path, array $params = []): string
  {
    $dir = explode('.', $path);
    $viewPath = implode(DIRECTORY_SEPARATOR, [self::$viewsDir, ...$dir]) . '.php';

    if (file_exists($viewPath)) {

      ob_start();

      foreach ($params as $key => $param) {
        $$key = $param;
      }

      require_once $viewPath;
      return ob_get_clean();
    }

    return '';
  }

  /**
   * @param $viewData The content of the view
   * 
   * @return array The parent view name and child data
   */
  public static function getContent(string $viewData): array
  {
    $mathes = [];

    preg_match("/@parent\(\'[a-zA-Z0-9.a-zA-Z0-9]+\'\)/", $viewData, $mathes);

    $found = current($mathes);

    $parentView = preg_replace("/(@parent|\(|\"|\'|\))/", '', $found);

    $viewContent = preg_replace("/@parent\(\'[a-zA-Z0-9.a-zA-Z0-9]+\'\)/", '', $viewData);

    return [$parentView, $viewContent];
  }
}
