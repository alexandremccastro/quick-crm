<?php

namespace App\Controllers;

abstract class BaseController
{
  public function __construct($requesAuth = false)
  {
    if ($requesAuth && !isAuthenticated()) redirect('/login');
    else if (!$requesAuth && isAuthenticated()) redirect('/home');
  }
}
