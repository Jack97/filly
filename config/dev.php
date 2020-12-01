<?php

use League\Flysystem\Local\LocalFilesystemAdapter;
use Symfony\Component\ErrorHandler\Debug;

require __DIR__ . '/prod.php';

Debug::enable();

$app['debug'] = true;

$app['filesystem.adapter'] = function () {
    return new LocalFilesystemAdapter(__DIR__ . '/../images');
};
