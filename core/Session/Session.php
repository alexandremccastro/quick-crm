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
    return $_SESSION[$key] ?? null;
  }

  public static function fetch(string $key, bool $asJSON = false): mixed
  {
    $data = null;
    if (isset($_SESSION[$key])) {
      $data = $_SESSION[$key];
      unset($_SESSION[$key]);

      return $asJSON ? json_encode($data, true) : $data;
    }

    return $asJSON ? json_encode(null) : $data;;
  }

  public static function destroy(): bool
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return session_destroy();

    return false;
  }
}
