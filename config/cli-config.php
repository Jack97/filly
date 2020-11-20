<?php

use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
require __DIR__ . '/dev.php';

return DependencyFactory::fromConnection(
    new PhpFile(__DIR__ . '/migrations.php'),
    new ExistingConnection($app['db'])
);
