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

  private static mixed $contentData = [];

  /**
   * This params will be set in session when the response is sent
   */
  private static $params = [];

  public static function with(array $params)
  {
    self::$params = $params;

    return self::getInstance();
  }

  /**
   * Sets the status of the response
   * 
   * @param $statusCode The status of the response
   * 
   * @return Response The class returns itself
   */
  public static function withStatus(HttpStatus $statusCode): Response
  {
    self::$httpCode = $statusCode;
    return self::getInstance();
  }

  /**
   * Place some headers in the response
   * 
   * @param $newHeaders New headers to be merged
   * 
   * @return Response The class returns itself
   */
  public static function withHeaders(array $newHeaders): Response
  {
    self::$headers = array_merge(self::$headers, $newHeaders);
    return self::getInstance();
  }

  /**
   * Method used to create json responses
   * 
   * @param $cotent The JSON body
   * 
   * @return Response The class returns itself
   */
  public static function json(array $content): Response
  {
    self::$contentType = 'application/json';
    self::$content = json_encode($content);
    return self::getInstance();
  }

  /**
   * Sets the content of the response
   * 
   * @param $content The content of the response
   * 
   * @return Response The class returns itself
   */
  public static function setContent(mixed $content, array $data = []): Response
  {
    self::$content = $content;
    self::$contentData = $data;
    return self::getInstance();
  }

  /**
   * Sends a HTTP response to the browser
   * 
   * @return Response The class returns itself
   */
  public static function send()
  {
    foreach (self::$params as $key => $value) {
      session()->set($key, $value);
    }

    foreach (self::$headers as $header) {
      header($header, true);
    }

    http_response_code(self::$httpCode->value);
    echo self::$content;

    return self::getInstance();
  }

  /**
   * @return string The content type of the response
   */
  public static function getContentType()
  {
    return self::$contentType;
  }

  /**
   * @return int The status code of the response
   */
  public static function getHttpCode(): int
  {
    return self::$httpCode->value;
  }


  /**
   * @return mixed The content of the response
   */
  public static function getContent()
  {
    return self::$content;
  }

  /**
   * @return array The headers of the response
   */
  public static function getHeaders()
  {
    return self::$headers;
  }

  /**
   * @return array The response params
   */
  public static function getParams()
  {
    return self::$params;
  }

  public static function clearPrevious()
  {
    self::$headers = [];
    self::$params = [];
    self::$content = '';
    self::$contentData = [];
    self::$httpCode = HttpStatus::OK;
  }
}
