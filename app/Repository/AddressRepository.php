<?php

namespace App\Repository;

use App\Models\Address;
use Core\Database\Repository;


class AddressRepository extends Repository
{
  public function __construct()
  {
    parent::__construct(new Address());
  }

  public function paginate(array $data, $page = 0)
  {
  }
}
