<?php

namespace App\Validations\Customers;

use App\Models\Customer;
use Core\Validation\Rule;
use Core\Validation\Validation;

class UpdateCustomerValidation extends Validation
{
  public function __construct(array $data)
  {
    parent::__construct($data);
  }

  public function rules(): array
  {
    return [
      'name' => $this->builder()->required()->string()->min(2)->max(100)->trim(),
      'phone' => $this->builder()->required()->string()->max(20),
      'cpf' => $this->builder()->required()->string()->length(14)->onlyDigits()->trim()
        ->customRule($this->cpfMustBeValid()),
      'cnpj' => $this->builder()->required()->string()->length(18)
        ->min(11)->customRule($this->cnpjMustBeValid())->onlyDigits()->trim(),
      'address' => $this->builder()->required()->array()->minCount(1),
      'birth_date' => $this->builder()->required()->date()
    ];
  }
  public function cpfMustBeValid(): Rule
  {
    return new Rule('CPF is invalid', function ($cpf) {
      return validateCPF($cpf);
    }, true);
  }

  public function cpfMustBeUnique(): Rule
  {
    return new Rule('CPF already exists', function ($cpf) {
      $customerModel = new Customer();
      $cpf = preg_replace("/[^0-9]/is", '', $cpf);
      $found = $customerModel->findOne(['cpf', '=', $cpf]);

      return $found == null;
    }, true);
  }

  public function cnpjMustBeValid(): Rule
  {
    return new Rule('CNPJ is invalid', function ($cnpj) {
      return validateCNPJ($cnpj);
    }, true);
  }

  public function cnpjMustBeUnique(): Rule
  {
    return new Rule('CNPJ already exists', function ($cnpj) {
      $customerModel = new Customer();
      $cnpj = preg_replace("/[^0-9]/is", '', $cnpj);
      $found = $customerModel->findOne(['cnpj', '=', $cnpj]);

      return $found == null;
    }, true);
  }
}
