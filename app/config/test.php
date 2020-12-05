<?php

use League\Flysystem\Local\LocalFilesystemAdapter;

require __DIR__ . '/dev.php';

$app['filesystem.adapter'] = function () {
    return new LocalFilesystemAdapter(__DIR__ . '/../tests/images');
};
