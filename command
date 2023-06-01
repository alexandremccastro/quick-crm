<?php
require_once __DIR__ . '/vendor/autoload.php';

use Core\App;

$app = new App();

[, $command] = $argv;

$app->exec($command);
