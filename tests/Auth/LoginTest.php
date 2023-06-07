<?php

namespace Tests\Auth;

use App\Repository\UserRepository;
use Core\App;
use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase
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

    if (!$found)
      $userRepository->insertOne($data);
  }


  /**
   * @test
   */
  public function emptyCredentialsShouldEmmitAnError()
  {
    $response = $this->app->post('/login', []);

    $headers = $response->getHeaders();
    $params = $response->getParams();
    $this->assertTrue(true);

    $this->assertContains('Location: /login', $headers, "Should redirect to login");
  }

  /**
   * @test
   */
  public function invalidUserShouldNotLogin()
  {

    $response = $this->app->post('/login', [
      'email' => 'invalid@email.com',
      'password' => 'password'
    ]);

    $headers = $response->getHeaders();
    $params = $response->getParams();

    $this->assertArrayHasKey('alert', $params, 'Must contain an alert message');
    $this->assertEquals('error', $params['alert']['type']);
    $this->assertEquals('Invalid credentials!', $params['alert']['message']);
    $this->assertContains('Location: /login', $headers, "Should redirect to login");
  }


  /**
   * @test
   */
  public function validUserShouldSuccessfullyLogin()
  {
    $response = $this->app->post('/login', [
      'email' => 'jhondoe@fakemail.com',
      'password' => 'qwe123'
    ]);

    $headers = $response->getHeaders();
    $params = $response->getParams();
    $alert = $params['alert'];

    $this->assertArrayHasKey('alert', $params, 'Should contain an alert message');
    $this->assertEquals('success', $alert['type'], 'Should be a success alert');
    $this->assertEquals('Successfully logged in!', $alert['message'], 'Should has a correct message');
    $this->assertContains('Location: /home', $headers, "Should redirect to home page");
  }
}
