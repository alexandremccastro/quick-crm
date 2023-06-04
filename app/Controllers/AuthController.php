<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\OnlyNonAuthenticated;
use Exception;

class AuthController
{
  use OnlyNonAuthenticated;

  public function showLoginView()
  {
    return view('auth.login');
  }

  public function login()
  {
    try {
      $data = request()->all();

      $user = new User();
      $found = $user->findOne(['email', '=', $data['email']]);

      // Not found or invalid credentials
      if (!$found || !password_verify($data['password'], $found->password)) {
        return redirect('/login')->with(['alert' => ['type' => 'error', 'message' => 'Invalid credentials!']]);
      } else {
        session()->set('user', $found);
        return redirect('/home');
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function showRegisterView()
  {
    return view('auth.register');
  }

  public function register()
  {
    try {
      $data = request()->all();

      $user = new User();

      $found = $user->findOne(['email', '=', $data['email']]);

      if ($found)
        return redirect('/register')
          ->with(['alert' => ['type' => 'error', 'message' => 'Email already used.']]);

      $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

      $user->insertOne($data);

      return redirect('/login')->with(['alert' => ['type' => 'success', 'message' => 'Account created!']]);
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  public function logout()
  {
    session()->destroy();
    return redirect('/login');
  }
}
