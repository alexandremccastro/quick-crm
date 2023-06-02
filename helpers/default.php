<?php

use Core\Env\Parser;
use Core\Http\Request;
use Core\Http\Server;
use Core\View\View;

/**
 * Redirects the page to a given location
 * 
 * @param $path The path that will be redirected
 */
function redirect(string $path)
{
  header("Location: $path");
}

/**
 * Shorthand function that helps load views
 * 
 * @param $path The path of the view
 * @param $params The params passed to the view
 * 
 */
function view(string $path, array $params = [])
{
  return View::load($path, $params);
}

/**
 * Gets a key from env file
 * 
 * @param $key The env file param
 * 
 * @return string The value of the key
 */
function env(string $key)
{
  return Parser::get($key);
}

/**
 * Helper that allows access params of the current request
 */
function request(): Request
{
  return Request::getInstance();
}


/**
 * Helper that allows access params of the server
 */
function server(): Server
{
  return Server::getInstance();
}
