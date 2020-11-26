<?php

use League\Flysystem\Local\LocalFilesystemAdapter;

$app['db.options'] = [
    'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
    'host' => $_ENV['DB_HOST'],
    'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
];

$app['flysystem.adapter'] = function () {
    return new LocalFilesystemAdapter(__DIR__ . '/../images');
};

$app['image.manager.driver'] = 'gd';
