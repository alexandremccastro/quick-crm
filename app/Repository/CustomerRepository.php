<?php

namespace App\Repository;

use App\Models\Customer;
use Core\Database\Repository;
use PDO;

class CustomerRepository extends Repository
{
  public function __construct()
  {
    parent::__construct(new Customer());
  }

  public function paginate(array $data, $page = 1, $perPage = 10)
  {
    [$result] = $this->select(['COUNT(*) as total'])
      ->where('user_id', '=', user()->id)->execute()->fetchAll(PDO::FETCH_OBJ);

    $query = $this->select()->where('user_id', '=', user()->id);

    if (isset($data['search'])) {
      $search = $data['search'];

      $query->andWhere('name', 'like', "$search%")
        ->orWhere('cpf', 'like', "$search%")
        ->orWhere('cnpj', 'like', "$search%")
        ->orWhere('phone', 'like', "$search%");
    }

    $records = $query->offset(($page - 1) * $perPage)->limit($perPage)
      ->execute()->fetchAll(PDO::FETCH_ASSOC);

    return [
      'records' => $records,
      'perPage' => $perPage,
      'currentPage' => $page,
      'totalPages' => round($result->total / $perPage)
    ];
  }
}
