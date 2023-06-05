<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Repository\AddressRepository;
use App\Repository\CustomerRepository;
use App\Validations\Customers\CreateCustomerValidation;
use App\Validations\Customers\UpdateCustomerValidation;
use Core\Database\DB;
use Core\Exceptions\ValidationException;
use PDO;

class CustomerController extends BaseController
{
  private CustomerRepository $customerRepository;
  private AddressRepository $addressRepository;

  public function __construct()
  {
    parent::__construct(true);

    $this->customerRepository = new CustomerRepository();
    $this->addressRepository = new AddressRepository();
  }

  public function index()
  {
    $currentPage = request()->get('page') ?? 1;
    $pagination = $this->customerRepository
      ->paginate(request()->all(), $currentPage);


    return view('customers.index', compact('pagination'));
  }

  public function create()
  {
    return view('customers.create');
  }

  public function edit(string $id)
  {
    $customer = $this->customerRepository->where('id', '=', $id)
      ->andWhere('user_id', '=', user()->id)->execute()->fetch(PDO::FETCH_ASSOC);

    if (!$customer) return view('errors.404')->with(['error' => 'Not found.']);

    $addresses = $this->addressRepository->findMany('customer_id', '=', $customer["id"]);
    $customer['addresses'] = $addresses;

    return view('customers.edit', compact('customer', 'id'));
  }

  public function save()
  {
    try {
      $data = request()->all();

      $customerValidation = new CreateCustomerValidation($data);
      $validated = $customerValidation->validate();

      DB::beginTransaction();
      $addresses = $validated['address'];
      unset($validated['address']);

      $validated['user_id'] = user()->id;

      $customerId = $this->customerRepository->insertOne($validated);

      foreach ($addresses as $data) {
        $data['customer_id'] = $customerId;
        unset($data['id']);
        $this->addressRepository->insertOne($data);
      }

      DB::commitTransaction();

      return redirect('/customers');
    } catch (ValidationException $e) {
      DB::rollbackTransaction();
      return redirect('/customers/create')->with(['errors' => $e->getErrors()]);
    }
  }

  public function update(string $id)
  {
    try {
      $data = request()->all();

      $customerValidation = new UpdateCustomerValidation($data);
      $validated = $customerValidation->validate();

      DB::beginTransaction();
      $addresses = $validated['address'];
      unset($validated['address']);

      $this->customerRepository->update($validated)
        ->where('id', '=', $id)->andWhere('user_id', '=', user()->id)->execute();

      foreach ($addresses as $data) {
        $data['customer_id'] = $id;

        if (isset($data['id']) && !empty($data['id']))
          $this->addressRepository->updateOne($data['id'], $data);
        else {
          unset($data['id']);
          $this->addressRepository->insertOne($data);
        }
      }

      DB::commitTransaction();

      return redirect('/customers')
        ->with(['alert' => ['type' => 'success', 'message' => 'Customer updated.']]);
    } catch (ValidationException $e) {
      DB::rollbackTransaction();
      return redirect("/customers/$id/edit")->with(['errors' => $e->getErrors()]);
    }
  }

  public function show(string $id)
  {
    echo 'See customer ' . $id;
  }

  public function favorites()
  {
    try {
      $validation = new \App\Validations\Auth\LoginValidation(['email' => 123, 'password' => 12]);
      $validation->validate();
    } catch (ValidationException $e) {
      var_dump($e->getErrors());
    }
  }

  public function delete(string $id)
  {
    $this->customerRepository->delete()
      ->where('id', '=', $id)
      ->andWhere('user_id', '=', user()->id)->execute();

    return redirect('/customers')
      ->with(['alert' => ['type' => 'success', 'message' => 'Successfully deleted']]);
  }
}
