<?php

namespace App\Controllers;

use App\Repository\UserRepository;
use App\Validations\Auth\LoginValidation;
use App\Validations\Auth\RegisterValidation;
use Core\Exceptions\ValidationException;

class AuthController extends BaseController
{

  private UserRepository $userRepository;

  public function __construct()
  {
    parent::__construct(false);

    $this->userRepository = new UserRepository();
  }

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

      $found = $this->userRepository->findOne('email', '=', $validated['email']);

      // Not found or invalid credentials
      if (!$found || !password_verify($validated['password'], $found['password'])) {
        return redirect('/login')->with(['alert' => ['type' => 'error', 'message' => 'Invalid credentials!']]);
      } else {
        session()->set('user',  (object) $found);
        return redirect('/home')->with(['alert' => ['type' => 'success', 'message' => 'Successfully logged in!']]);
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

      $validated['password'] = password_hash($validated['password'], PASSWORD_BCRYPT);

      $this->userRepository->insertOne($validated);

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
