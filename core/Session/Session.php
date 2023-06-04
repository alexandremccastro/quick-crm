<?php

namespace Core\Session;

use Core\Traits\Singletron;

final class Session
{
  use Singletron;

  public static function start(): bool
  {
    if (session_status() !== PHP_SESSION_ACTIVE)
      return session_start();
    else return true;
  }

  public static function push(string $key, mixed $value)
  {
    $_SESSION[$key][] = $value;
  }

  public static function set(string $key, mixed $value)
  {
    $_SESSION[$key] = $value;
  }

  public static function get(string $key): mixed
  {
    return $_SESSION[$key];
  }

  public static function destroy(): bool
  {
    return session_destroy();
  }
}
