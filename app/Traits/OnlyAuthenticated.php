<?php


namespace App\Traits;

trait OnlyAuthenticated
{
  public function __construct()
  {
    if (!isAuthenticated())
      redirect('/login')->with(['alert' => ['type' => 'error', 'message' => 'Permission denied!']]);
  }
}
