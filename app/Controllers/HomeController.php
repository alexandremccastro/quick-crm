<?php

namespace App\Controllers;

use App\Repository\AddressRepository;
use App\Repository\CustomerRepository;
use PDO;

class HomeController extends BaseController
{
  private CustomerRepository $customerRepository;
  private AddressRepository $addressRepository;

  public function __construct()
  {
    parent::__construct(true);

    $this->customerRepository = new CustomerRepository();
    $this->addressRepository = new AddressRepository();
  }

  public function home()
  {
    $customerQuery = $this->customerRepository
      ->select(['COUNT(*) as totalCustomers'])
      ->where('user_id', '=', user()->id)
      ->execute()->fetchObject();

    $favoriteQuery = $this->customerRepository
      ->select(['COUNT(*) as favoriteCount'])
      ->where('user_id', '=', user()->id)
      ->andWhere('is_favorite', '=', 1)
      ->execute()->fetchObject();

    $customersIds = $this->customerRepository
      ->select(['id'])->where('user_id', '=', user()->id)
      ->execute()->fetchAll(PDO::FETCH_OBJ);

    $parsed = [];

    foreach ($customersIds as $data) {
      $parsed[] = $data->id;
    }

    $addressQuery = $this->addressRepository
      ->select(['COUNT(*) as totalAddresses'])
      ->andIn('customer_id', $parsed)
      ->execute()->fetchObject();

    $data = [
      'favoriteCount' => $favoriteQuery->favoriteCount,
      'totalCustomers' => $customerQuery->totalCustomers,
      'totalAddresses' => $addressQuery->totalAddresses
    ];

    return view('home', compact('data'));
  }
}
