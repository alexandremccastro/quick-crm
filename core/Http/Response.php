<?php

namespace Core\Http;

use Core\Traits\Singletron;

final class Response
{
  use Singletron;

  private static $headers = [];

  private static string $contentType = 'text/plain';

  private static HttpStatus $httpCode = HttpStatus::OK;

  private static mixed $content = null;


  public static function withStatus(HttpStatus $statusCode): Response
  {
    self::$httpCode = $statusCode;
    return self::getInstance();
  }


  public static function withHeaders(array $newHeaders): Response
  {
    self::$headers = array_merge(self::$headers, $newHeaders);
    return self::getInstance();
  }

  public static function json(array $content): Response
  {
    self::$contentType = 'application/json';
    self::$content = json_encode($content);
    return self::getInstance();
  }

  public static function setContent(mixed $content): Response
  {
    self::$content = $content;
    return self::getInstance();
  }

  public static function send()
  {
    foreach (self::$headers as $header) {
      header($header, true);
    }

    http_response_code(self::$httpCode->value);
    echo self::$content;

    return self::getInstance();
  }

  public static function getContentType()
  {
    return self::$contentType;
  }


  public static function getHttpCode()
  {
    return self::$httpCode;
  }


  public static function getContent()
  {
    return self::$content;
  }

  public static function getHeaders()
  {
    return self::$headers;
  }
}
