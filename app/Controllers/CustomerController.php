<?php

namespace App\Controllers;

use App\Traits\OnlyAuthenticated;

class CustomerController
{
  use OnlyAuthenticated;

  public function index()
  {
    view('customers.index');
  }

  public function show(string $id)
  {
    echo 'See customer ' . $id;
  }
}
