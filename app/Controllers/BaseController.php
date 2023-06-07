<?php

namespace App\Controllers;

use Core\Http\Response;

abstract class BaseController
{
  public function __construct(private bool $requiresAuth = false)
  {
  }

  public function preload(): Response | null
  {
    if ($this->requiresAuth && !isAuthenticated())
      return redirect('/login')->with(['alert' => ['type' => 'error', 'message' => 'Permission denied!']]);
    else if (!$this->requiresAuth && isAuthenticated()) return redirect('/home');

    return null;
  }
}
