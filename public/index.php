<?php

define('BASEPATH', implode(DIRECTORY_SEPARATOR, [__DIR__, '..']));

require_once BASEPATH . '/vendor/autoload.php';

use Core\App;

$app = new App();

$app->run($_SERVER['REQUEST_URI']);
