<?php

namespace Tests\Auth;

use App\Repository\UserRepository;
use Core\App;
use PHPUnit\Framework\TestCase;

final class RegisterTest extends TestCase
{
  private App $app;

  protected function setUp(): void
  {
    $this->app = new App(true);

    $userRepository = new UserRepository();

    $data = [
      'name' => 'Jhon Doe',
      'email' => 'jhondoe@fakemail.com',
      'password' => password_hash('qwe123', PASSWORD_BCRYPT)
    ];

    $found = $userRepository->findOne('email', '=', 'jhondoe@fakemail.com');
    $userRepository->deleteOne('email', '=', 'jhondoe@validemail.com');

    if (!$found)
      $userRepository->insertOne($data);
  }


  /**
   * @test
   */
  public function emptyRequestShouldEmmitErrors()
  {
    $response = $this->app->post('/register', []);


    $headers = $response->getHeaders();
    $params = $response->getParams();
    $errors = $params['errors'];


    $this->assertArrayHasKey('name', $errors, "Should not have erros in user name.");
    $this->assertArrayHasKey('email', $errors, "Should have erros in user email.");
    $this->assertArrayHasKey('password', $errors, "Should not have erros in user password.");
    $this->assertContains('Location: /register', $headers, "Should redirect to register page");
  }

  /**
   * @test
   */
  public function newUserCantUseRegisteredEmail()
  {
    $response = $this->app->post('/register', [
      'name' => 'Jhon Test',
      'email' => 'jhondoe@fakemail.com',
      'password' => 'qwe123'
    ]);


    $headers = $response->getHeaders();
    $params = $response->getParams();
    $errors = $params['errors'];

    $this->assertArrayNotHasKey('name', $errors, "Should have erros in user name.");
    $this->assertArrayHasKey('email', $errors, "Should have erros in user email.");
    $this->assertArrayNotHasKey('password', $errors, "Should have erros in user password.");
    $this->assertContains('Location: /register', $headers, "Should redirect to register page");
  }

  /**
   * @test
   */
  public function validDataShouldRegisterSuccessfully()
  {
    $response = $this->app->post('/register', [
      'name' => 'Jhon Test',
      'email' => 'jhondoe@validemail.com',
      'password' => 'qwe123'
    ]);


    $headers = $response->getHeaders();
    $params = $response->getParams();
    $alert = $params['alert'];

    $this->assertEquals('success', $alert['type'], "Should have erros in user name.");
    $this->assertEquals('Account created!', $alert['message'], "Should have erros in user email.");
    $this->assertContains('Location: /login', $headers, "Should redirect to login page");
  }
}
