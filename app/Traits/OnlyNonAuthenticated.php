<?php


namespace App\Traits;

trait OnlyNonAuthenticated
{
  public function __construct()
  {
    if (isAuthenticated()) redirect('/home');
  }
}
