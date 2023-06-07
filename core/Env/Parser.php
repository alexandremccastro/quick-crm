<?php

namespace Core\Env;

abstract class Parser
{
  private static array $data = [];

  public static function parse()
  {
    $filePath = implode(DIRECTORY_SEPARATOR, [BASEPATH, ".env"]);

    if (file_exists($filePath))
      self::$data = parse_ini_file($filePath);
  }

  public static function get($key)
  {
    if (count(self::$data) == 0)
      self::parse();

    return self::$data[$key] ?? null;
  }
}
