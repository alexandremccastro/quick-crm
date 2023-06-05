<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Validations\Customers\CreateCustomerValidation;
use App\Validations\Customers\UpdateCustomerValidation;
use Core\Exceptions\ValidationException;

class CustomerController extends BaseController
{
  public function __construct()
  {
    parent::__construct(true);
  }

  public function index()
  {
    $customer = new Customer();
    $stmt = $customer->db()->prepare('SELECT * from customers where user_id = :user_id ORDER BY id DESC');
    $stmt->execute(['user_id' => user()->id]);
    $customers = $stmt->fetchAll();

    return view('customers.index', compact('customers'));
  }

  public function create()
  {
    return view('customers.create');
  }

  public function edit(string $id)
  {
    $model = new Customer();

    $customer = $model->findOne(['id', '=', $id]);

    $address = new Address();

    $addresses = $address->findOne(['customer_id', '=', $customer->id]);

    $customer->addresses[] = $addresses;

    return view('customers.edit', compact('customer', 'id'));
  }

  public function save()
  {
    try {
      $data = request()->all();

      $customerValidation = new CreateCustomerValidation($data);
      $validated = $customerValidation->validate();

      $addresses = $validated['address'];
      unset($validated['address']);

      $validated['user_id'] = user()->id;

      $customer = new Customer();
      $customerId = $customer->insertOne($validated);

      $address = new Address();

      foreach ($addresses as $data) {
        $data['customer_id'] = $customerId;
        $address->insertOne($data);
      }

      return redirect('/customers');
    } catch (ValidationException $e) {
      return redirect('/customers/create')->with(['errors' => $e->getErrors()]);
    }
  }

  public function update(string $id)
  {
    try {
      $customerModel = new Customer();
      $data = request()->all();

      $customerValidation = new UpdateCustomerValidation($data);
      $validated = $customerValidation->validate();

      $addresses = $validated['address'];
      unset($validated['address']);

      $customerModel->updateOne($id, $validated);

      $addressModel = new Address();

      foreach ($addresses as $data) {
        $data['customer_id'] = $id;

        if (isset($data['id']) && !empty($data['id']))
          $addressModel->updateOne($data['id'], $data);
        else {
          unset($data['id']);
          $addressModel->insertOne($data);
        }
      }

      return redirect('/customers')
        ->with(['alert' => ['type' => 'success', 'message' => 'Customer updated.']]);
    } catch (ValidationException $e) {
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
    $customer = new Customer();

    $customer->deleteOne($id);

    return redirect('/customers');
  }
}
