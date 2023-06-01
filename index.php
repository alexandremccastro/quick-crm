<?php
require_once __DIR__ . '/vendor/autoload.php';

use Core\App;

$app = new App();

$app->run($_SERVER['REQUEST_URI']);
