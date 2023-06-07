<?php

namespace Tests\Customers;

use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use Core\App;
use PHPUnit\Framework\TestCase;

final class CreateCustomerTest extends TestCase
{
  private App $app;

  private UserRepository $userRepository;
  private CustomerRepository $customerRepository;

  protected function setUp(): void
  {
    $this->app = new App(true);

    $this->userRepository = new UserRepository();
    $this->customerRepository = new CustomerRepository();

    $data = [
      'name' => 'Jhon Doe',
      'email' => 'jhondoe@fakemail.com',
      'password' => password_hash('qwe123', PASSWORD_BCRYPT)
    ];

    $foundUser = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');

    if (!$foundUser)
      $userId = $this->userRepository->insertOne($data);
    else $userId = $foundUser['id'];

    $this->customerRepository->delete()
      ->where('user_id', '=', $userId)
      ->andWhere('cpf', '=', '46542763007')
      ->orWhere('cnpj', '=', '09890301000102')->execute();

    $this->customerRepository->delete()
      ->where('cpf', '=', '78181291034')
      ->orWhere('cnpj', '=', '46005336000148')->execute();

    $this->customerRepository->insertOne([
      'user_id' => $userId,
      'name' => 'Walter white',
      'phone' => '11233334445',
      'birth_date' => date('Y-m-d'),
      'cpf' => '78181291034',
      'cnpj' => '46005336000148'
    ]);
  }


  /**
   * @test
   */
  public function unauthorizedUserCannotCreateCustomer()
  {
    $response = $this->app->post('/customers');

    $headers = $response->getHeaders();
    $params = $response->getParams();

    $this->assertArrayHasKey('alert', $params, "Should have an alert message");
    $this->assertContains('Location: /login', $headers, "Should redirect to login");
  }

  /**
   * @test
   */
  public function cannotCreateACustomerWithoutAddress()
  {
    $user = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');

    $this->app->setAuthenticatedUser($user);

    $response = $this->app->post('/customers', [
      'name' => 'Maria Salma',
      'phone' => '(11) 98882-2333',
      'cpf' => '465.427.630-07',
      'cnpj' => '09.890.301/0001-02',
      'birth_date' => date('Y-m-d')
    ]);

    $headers = $response->getHeaders();
    $params = $response->getParams();

    $errors = $params['errors'];

    $this->assertArrayHasKey('errors', $params, "Should have validation errors");
    $this->assertNotNull($errors['address'], "Should have errors in address field");
    $this->assertContains('This field is required', $errors['address'], 'Should have required error');
    $this->assertContains('Must be an array', $errors['address'], 'Must have is array error');
    $this->assertContains('Must have at least 1 elements', $errors['address'], 'Must have min elements error');
    $this->assertContains('Location: /customers/create', $headers, "Should redirect customers creation");
  }

  /**
   * Cannot create customer with invalid documents
   * 
   * @test
   */
  public function cannotCreateACustomerWithInvalidDocuments()
  {
    $user = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');

    $this->app->setAuthenticatedUser($user);

    $response = $this->app->post('/customers', [
      'name' => 'Maria Salma',
      'phone' => '(11) 98882-2333',
      'cpf' => '11.111.111-11',
      'cnpj' => '11.111.111/1111-11',
      'birth_date' => date('Y-m-d')
    ]);

    $headers = $response->getHeaders();
    $params = $response->getParams();

    $errors = $params['errors'];

    $this->assertArrayHasKey('errors', $params, "Should have validation errors");
    $this->assertArrayHasKey('cpf', $errors, "Must have validation errors for cpf");
    $this->assertArrayHasKey('cnpj', $errors, "Must have validation errors for cnpj");
    $this->assertContains('Location: /customers/create', $headers, "Should redirect customers creation");
  }


  /**
   * Cannot create customer with already used documents
   * 
   * @test
   */
  public function cannotCreateACustomerWithAlreadyUsedDocuments()
  {
    $user = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');

    $this->app->setAuthenticatedUser($user);

    $response = $this->app->post('/customers', [
      'name' => 'Walter white',
      'phone' => '(11) 23333-4445',
      'birth_date' => date('Y-m-d'),
      'cpf' => '781.812.910-34',
      'cnpj' => '460.053.36/0001-48',
      'address' => [
        [
          'street' => 'Street 1',
          'number' => '188',
          'zip_code' => '46430-000',
          'city' => 'Caiman',
          'state' => 'Piton',
          'country' => 'MA'
        ],
      ]
    ]);

    $headers = $response->getHeaders();
    $params = $response->getParams();

    $errors = $params['errors'];

    $this->assertArrayHasKey('errors', $params, "Should have validation errors");
    $this->assertArrayHasKey('cpf', $errors, "Must have validation errors for cpf");
    $this->assertArrayHasKey('cnpj', $errors, "Must have validation errors for cnpj");
    $this->assertContains('Location: /customers/create', $headers, "Should redirect customers creation");
  }


  /**
   * Cannot create customer with invalid documents
   * 
   * @test
   */
  public function mustCreateAUserWithValidDocumentsAndWithAddress()
  {
    $user = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');

    $this->app->setAuthenticatedUser($user);

    $response = $this->app->post('/customers', [
      'name' => 'Maria Salma',
      'phone' => '(11) 98882-2333',
      'cpf' => '465.427.630-07',
      'cnpj' => '09.890.301/0001-02',
      'birth_date' => date('Y-m-d'),
      'address' => [
        [
          'street' => 'Street 1',
          'number' => '188',
          'zip_code' => '46430-000',
          'city' => 'Caiman',
          'state' => 'Piton',
          'country' => 'MA'
        ],
        [
          'street' => 'Street 1',
          'number' => '188',
          'zip_code' => '46430-000',
          'city' => 'Caiman',
          'state' => 'Piton',
          'country' => 'MA'
        ]
      ]
    ]);

    $headers = $response->getHeaders();

    $this->assertContains('Location: /customers', $headers, "Should redirect to customers page");
  }
}
