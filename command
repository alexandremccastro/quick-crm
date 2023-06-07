<?php
define('BASEPATH', __DIR__);

require_once BASEPATH . "/vendor/autoload.php";

use Core\App;

$app = new App();

[, $command] = $argv;

$app->exec($command);
