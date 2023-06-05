<?php

namespace Core;

use Core\Http\Response;
use Core\Routing\Route;
use Core\Scripts\Loader;
use Database\MigrationRunner;

class App
{
  public function __construct()
  {
    $this->load();

    date_default_timezone_set(env('TIMEZONE', 'UTC'));

    session()->start();
  }

  public function run(string $requestURI)
  {
    Route::dispatch($requestURI);
  }

  public function load()
  {
    Loader::load(['routes', 'helpers']);
  }


  public function post(string $uri, array $data = []): Response
  {
    // ob_start();
    $_POST = $data;
    server()->setRequestMethod('POST');

    return Route::dispatch($uri);
  }

  /**
   * Executes a given command provided by the shell
   * 
   * @param $command The command that will be executed
   */
  public function exec(string $command)
  {
    switch ($command) {
      case 'serve':
        $port = env('APP_PORT');
        $host = env('APP_HOST');
        shell_exec("php -S $host:$port ./index.php");
        break;
      case 'migrate':
        MigrationRunner::execute();
        break;
      default:
        throw new \Exception('Invalid command.');
    }
  }
}
