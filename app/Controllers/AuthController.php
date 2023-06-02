<?php

namespace App\Controllers;

class AuthController
{

  public function showLoginView()
  {
    $name = 'Alexandre';
    $company = 'Test';

    view('auth.login', compact('name', 'company'));
  }


  public function attemptLogin()
  {
    $name = 'Alexandre';
    $company = 'Test';

    $data = request()->all();

    var_dump($data);

    // view('auth.login', compact('name', 'company'));
  }

  public function register()
  {
    $name = 'Alexandre';
    $company = 'Test';

    view('auth.register', compact('name', 'company'));
  }
}
