<?php

namespace Core\Scripts;

abstract class Loader
{

  /**
   * Loads all files in a given directory/folder
   * 
   * @param $folder The path that the files will be loaded
   */
  public static function load(string $folder)
  {
    $files = scandir($folder);

    foreach ($files as $file) {
      $filePath = implode('/', [$folder, $file]);

      if (is_file($filePath)) {
        require_once $filePath;
      }
    }
  }
}
