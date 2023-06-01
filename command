<?php
require_once __DIR__ . '/vendor/autoload.php';

use Database\MigrationRunner;
use Core\App;

new App();

[, $command] = $argv;

switch ($command) {
  case 'serve':
    shell_exec('php -S localhost:8000 ./index.php');
    break;
  case 'migrate':
    MigrationRunner::execute();
    break;
}
