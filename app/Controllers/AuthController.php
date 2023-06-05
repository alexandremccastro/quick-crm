<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\OnlyNonAuthenticated;
use App\Validations\LoginValidation;
use App\Validations\RegisterValidation;
use Core\Exceptions\ValidationException;
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
      $loginValidation = new LoginValidation($data);

      $validated = $loginValidation->validate();

      $user = new User();
      $found = $user->findOne(['email', '=', $validated['email']]);

      // Not found or invalid credentials
      if (!$found || !password_verify($validated['password'], $found->password)) {
        return redirect('/login')->with(['alert' => ['type' => 'error', 'message' => 'Invalid credentials!']]);
      } else {
        session()->set('user', $found);
        return redirect('/home');
      }
    } catch (ValidationException $e) {
      return redirect('/login')->with(['errors' => $e->getErrors()]);
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
      $registerValidation = new RegisterValidation($data);
      $validated = $registerValidation->validate();

      $user = new User();

      $validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);

      $user->insertOne($validated);

      return redirect('/login')->with(['alert' => ['type' => 'success', 'message' => 'Account created!']]);
    } catch (ValidationException $e) {
      return redirect('/register')->with(['errors' => $e->getErrors()]);
    }
  }

  public function logout()
  {
    session()->destroy();
    return redirect('/login');
  }
}
