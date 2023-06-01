<?php

use Core\View\View;

function redirect(string $path)
{
  header("Location: $path");
}

function view(string $path, array $params = [])
{
  return View::load($path, $params);
}
