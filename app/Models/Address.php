<?php

namespace App\Models;

use Core\Database\Model;

class Address extends Model
{
  protected $primaryKey = 'id';

  protected $table = 'address';

  protected $fields = [
    'customer_id',
    'street',
    'number',
    'city',
    'state',
    'zip_code',
    'country'
  ];
}
