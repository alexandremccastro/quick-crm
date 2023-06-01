<?php

namespace App\Controllers;

use Core\View\View;

class AuthController
{

  public function login()
  {
    $name = 'Alexandre';
    $company = 'Test';

    $appName = env('APP_NAME');

    echo $appName;

    view('auth.login', compact('name', 'company'));
  }
}
