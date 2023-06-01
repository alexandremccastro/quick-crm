<?php

namespace Core\Database;

abstract class DB
{
  private static $instance = null;

  /**
   * Singletron method that ensures only one database connection across the app
   * 
   * @return \PDO A connection with the database
   */
  public static function db()
  {
    if (self::$instance == null) {
      self::$instance = new \PDO(self::getDNS(), self::getUser(), self::getPswd());
    }

    return self::$instance;
  }

  /**
   * @return string The DNS connection string
   */
  private static function getDNS(): string
  {
    $dbType = env('DB_TYPE');
    $dbHost = env('DB_HOST');
    $dbName = env('DB_NAME');

    return "$dbType:host=$dbHost;dbname=$dbName";
  }

  /**
   * @return string The database default user
   */
  private static function getUser(): string
  {
    return env('DB_USER');
  }

  /**
   * @return string The database password
   */
  private static function getPswd(): string
  {
    return env('DB_PASSWD');
  }
}
