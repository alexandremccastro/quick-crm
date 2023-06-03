<?php

namespace Tests;

use Core\App;
use PHPUnit\Framework\TestCase;


final class AuthTest extends TestCase
{

  /**
   * @test
   */
  public function userShouldLogin()
  {
    $app = new App();

    $response = $app->post('/login', [
      'email' => 'example@gmail.com',
      'password' => 'password'
    ]);

    $user = session()->get('user');

    $this->assertNotNull($user, "User should not be null");
    $this->assertEquals("Logged in successfully", $response);
  }
}
