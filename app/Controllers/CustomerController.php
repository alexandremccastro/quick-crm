<?php

namespace App\Controllers;

class CustomerController
{

  public function show(string $id)
  {
    echo 'See customer ' . $id;
  }
}
