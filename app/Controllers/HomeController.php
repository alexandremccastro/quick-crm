<?php

namespace App\Controllers;

use App\Traits\OnlyAuthenticated;

class HomeController
{
  use OnlyAuthenticated;

  public function home()
  {
    return view('home');
  }
}
