<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class AuthController
{

  public function showLoginView()
  {
    view('auth.login');
  }

  public function login()
  {
    try {
      $data = request()->all();

      $user = new User();
      $found = $user->findOne(['email', '=', $data['email']]);

      // Not found or invalid credentials
      if (!$found || !password_verify($data['password'], $found->password)) {
        redirect('/login');
      } else {
        session()->set('user', $found);
        redirect('/home');
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    // view('auth.login', compact('name', 'company'));
  }

  public function showRegisterView()
  {
    view('auth.register');
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
      redirect('/login');
    }
    // view('auth.login', compact('name', 'company'));
  }

  public function logout()
  {
    session()->destroy();
    redirect('/login');
  }
}
