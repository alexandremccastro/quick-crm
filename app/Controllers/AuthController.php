<?php

namespace App\Controllers;

use Core\View\View;

class AuthController
{

  public function login()
  {
    $name = 'Alexandre';
    $company = 'Test';

    view('auth.login', compact('name', 'company'));
  }
}
