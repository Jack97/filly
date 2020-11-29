<?php

use League\Flysystem\Local\LocalFilesystemAdapter;

require __DIR__ . '/prod.php';

$app['debug'] = true;

$app['flysystem.adapter'] = function () {
    return new LocalFilesystemAdapter(__DIR__ . '/../images');
};
