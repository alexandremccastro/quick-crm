<?php

namespace App\Models;

use Core\Database\Model;

class Customer extends Model
{
  protected $primaryKey = 'id';

  protected $table = 'customers';

  protected $fields = [
    'user_id',
    'name',
    'cpf',
    'cnpj',
    'birth_date',
    'phone'
  ];
}
