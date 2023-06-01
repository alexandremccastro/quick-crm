<?php

namespace App\Models;

use Core\Database\Model;

class User extends Model
{
  protected $primaryKey = 'id';

  protected $table = 'users';

  protected $fields = [
    'name',
    'email',
    'password'
  ];
}
