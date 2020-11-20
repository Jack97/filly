<?php

use League\Flysystem\Local\LocalFilesystemAdapter;

$app['db.options'] = [
    'driver' => 'pdo_mysql',
    'host' => 'host.docker.internal',
    'dbname' => 'filly',
    'charset' => 'utf8',
];

$app['flysystem.adapter'] = function () {
    return new LocalFilesystemAdapter(__DIR__ . '/../images');
};

$app['intervention.image.driver'] = 'gd';
