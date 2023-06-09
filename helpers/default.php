<?php

use Core\Env\Parser;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Server;
use Core\Session\Session;
use Core\View\View;

function response(): Response
{
  return Response::getInstance();
}

/**
 * Redirects the page to a given location
 * 
 * @param $path The path that will be redirected
 */
function redirect(string $path): Response
{
  return response()->withHeaders(["HTTP/1.1 302 Found", "Location: $path"]);
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
 * @param $default Default value if key is empty
 * 
 * @return string The value of the key
 */
function env(string $key, $default = null)
{
  return Parser::get($key) ?? $default;
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

/**
 * App session helper
 */
function session(): Session
{
  return Session::getInstance();
}

/**
 * Returns the data of the authenticated user
 */
function user(): mixed
{
  return session()->get('user');
}

function isAuthenticated(): bool
{
  return user() != null;
}
