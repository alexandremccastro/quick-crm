<?php

namespace Core;

use Core\Routing\Route;
use Core\Scripts\Loader;
use Database\MigrationRunner;

class App
{
  public function __construct()
  {
    $this->load();
  }

  public function run(string $requestURI)
  {
    $filePath = implode(DIRECTORY_SEPARATOR, [$_SERVER['DOCUMENT_ROOT'], $requestURI]);

    if (file_exists($filePath)) {
      $extension = pathinfo($filePath, PATHINFO_EXTENSION);

      $mimeTypes = [
        'txt' => 'text/plain',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'pdf' => 'application/pdf',
      ];

      $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

      echo header("Content-Type: $contentType");
      echo file_get_contents($filePath);
    } else {
      Route::dispatch($requestURI);
    }
  }

  public function load()
  {
    Loader::load(['routes', 'helpers']);
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
