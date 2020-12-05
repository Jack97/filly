<?php

use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Client;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Monolog\Logger;

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
