<?php

namespace Tests;

use Core\App;
use PHPUnit\Framework\TestCase;


final class AuthTest extends TestCase
{

  /**
   * @test
   */
  public function invalidUserShouldNotLogin()
  {
    $app = new App();

    $response = $app->post('/login', [
      'email' => 'example@gmail.com',
      'password' => 'password'
    ]);


    $this->assertContains('Location: /login', $response->getHeaders(), "Should redirect to login");
  }


  /**
   * @test
   */
  public function validUserShouldSuccessfullyLogin()
  {
    $app = new App();

    $response = $app->post('/login', [
      'email' => 'test@gmail.com',
      'password' => 'testpass'
    ]);



    $this->assertContains('Location: /home', $response->getHeaders(), "Should redirect to home page");
  }
}
