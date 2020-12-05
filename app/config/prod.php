<?php

use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Client;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Monolog\Logger;

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

$app['http.client'] = function () {
    return new Client();
};

$app['filesystem.adapter'] = function () {
    $client = new StorageClient();

    $bucket = $client->bucket($_ENV['GOOGLE_CLOUD_STORAGE_BUCKET']);

    return new GoogleCloudStorageAdapter($bucket);
};

$app['image.manager.driver'] = 'gd';

$app['monolog.logfile'] = fn() => $_ENV['ERROR_LOG_PATH'] ?? 'php://stderr';
$app['monolog.level'] = Logger::ERROR;
