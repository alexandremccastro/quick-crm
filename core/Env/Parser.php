<?php

namespace Core\Env;

abstract class Parser
{
  private static array $data = [];

  public static function parse()
  {
    if (file_exists('.env'))
      self::$data = parse_ini_file('.env');
  }

  public static function get($key)
  {
    if (count(self::$data) == 0)
      self::parse();

    return self::$data[$key] ?? null;
  }
}
