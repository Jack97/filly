<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$env = $_ENV['APP_ENV'] ?? 'prod';
require __DIR__ . "/../config/{$env}.php";

$app->run();
