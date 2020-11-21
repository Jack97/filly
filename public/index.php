<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$env = getenv('APP_ENV') ?: 'dev';
require __DIR__ . "/../config/{$env}.php";

$app->run();
