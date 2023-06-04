<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\HttpStatus;
use Exception;
use StatusCode;

class AuthController
{

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
        return redirect('/login');
      } else {
        session()->set('user', $found);
        return redirect('/home');
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    // view('auth.login', compact('name', 'company'));
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

      $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

      $user->insertOne($data);
    } catch (Exception $e) {
      echo $e->getMessage();
    } finally {
      return redirect('/login');
    }
    // view('auth.login', compact('name', 'company'));
  }

  public function logout()
  {
    session()->destroy();
    // header('Location: /login');
    return redirect('/login');
  }
}
