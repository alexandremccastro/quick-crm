<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Traits\OnlyAuthenticated;
use App\Validations\Customers\CreateCustomerValidation;
use Core\Exceptions\ValidationException;

class CustomerController
{
  use OnlyAuthenticated;

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
      $validated['cpf'] = preg_replace('/[^0-9]/is', '', $validated['cpf']);
      $validated['cnpj'] = preg_replace('/[^0-9]/is', '', $validated['cnpj']);

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
    $customerModel = new Customer();
    $data = request()->all();

    $addresses = $data['address'];
    unset($data['address']);
    unset($data['method']);
    $data['cpf'] = preg_replace('/([\.\-]+)/', '', $data['cpf']);
    $data['cnpj'] = preg_replace('/([\.\-\/]+)/', '', $data['cnpj']);
    $customerModel->updateOne($id, $data);

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
