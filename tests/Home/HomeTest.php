<?php

namespace Tests\Auth;

use App\Repository\UserRepository;
use Core\App;
use PHPUnit\Framework\TestCase;

final class HomeTest extends TestCase
{
  private App $app;

  private UserRepository $userRepository;

  protected function setUp(): void
  {
    $this->app = new App(true);

    $this->userRepository = new UserRepository();

    $data = [
      'name' => 'Jhon Doe',
      'email' => 'jhondoe@fakemail.com',
      'password' => password_hash('qwe123', PASSWORD_BCRYPT)
    ];

    $found = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');

    if (!$found)
      $this->userRepository->insertOne($data);
  }


  /**
   * @test
   */
  public function nonAuthenticatedUserCantSeeHomePage()
  {
    $response = $this->app->get('/home');

    $headers = $response->getHeaders();
    $params = $response->getParams();


    $this->assertArrayHasKey('alert', $params, "Should have an alert message");
    $this->assertContains('Location: /login', $headers, "Should redirect to login");
  }

  /**
   * @test
   */
  public function authenticatedUserMustSeeHomePage()
  {
    $user = $this->userRepository->findOne('email', '=', 'jhondoe@fakemail.com');
    $this->app->setAuthenticatedUser($user);
    $response = $this->app->get('/home');

    $params = $response->getParams();

    $this->assertArrayHasKey('data', $params, 'Should contain the data array');
    $this->assertArrayHasKey('favoriteCount', $params['data'], "Should have an favorite count");
    $this->assertArrayHasKey('totalCustomers', $params['data'], "Should have total customers");
    $this->assertArrayHasKey('totalAddresses', $params['data'], "Should have total addresses");
  }
}
