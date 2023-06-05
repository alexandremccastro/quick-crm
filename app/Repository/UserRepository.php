<?php

namespace App\Repository;

use App\Models\User;
use Core\Database\Repository;


class UserRepository extends Repository
{
  public function __construct()
  {
    parent::__construct(new User());
  }
}
