<?php

use League\Flysystem\Local\LocalFilesystemAdapter;

require __DIR__ . '/dev.php';

$app['db.options'] = [
    'driver' => 'pdo_sqlite',
    'memory' => true,
];

$app['flysystem.adapter'] = function () {
    return new LocalFilesystemAdapter(__DIR__ . '/../tests/images');
};

unset($app['exception_handler']);
