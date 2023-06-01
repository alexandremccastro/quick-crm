<?php

namespace Core;

use Core\Routing\Route;
use Core\Scripts\Loader;

class App
{
  public function __construct()
  {
    $this->load();
  }

  public function run(string $requestURI)
  {
    Route::dispatch($requestURI);
  }

  public function load()
  {
    Loader::load(['routes', 'helpers']);
  }
}
