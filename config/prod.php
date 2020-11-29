<?php

use Google\Cloud\Storage\StorageClient;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;

$app['db.options'] = function () {
    return [
        'driver' => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
        'host' => $_ENV['DB_HOST'],
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
        'dbname' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    ];
};

$app['flysystem.adapter'] = function () {
    $client = new StorageClient();

    $bucket = $client->bucket($_ENV['GOOGLE_CLOUD_STORAGE_BUCKET']);

    return new GoogleCloudStorageAdapter($bucket);
};

$app['image.manager.driver'] = fn() => 'gd';
