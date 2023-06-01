<?php

use Core\Env\Parser;
use Core\View\View;

function redirect(string $path)
{
  header("Location: $path");
}

function view(string $path, array $params = [])
{
  return View::load($path, $params);
}

function env(string $key)
{
  return Parser::get($key);
}
