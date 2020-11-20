<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

require __DIR__ . '/../config/dev.php';

$app->run();
