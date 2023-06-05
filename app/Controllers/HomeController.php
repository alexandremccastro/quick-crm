<?php

namespace App\Controllers;

use App\Traits\OnlyAuthenticated;

class HomeController
{

  public function home()
  {
    return view('home');
  }
}
