<?php

use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Symfony\Component\ErrorHandler\Debug;

require __DIR__ . '/prod.php';

Debug::enable();

$app['debug'] = true;

$app['filesystem.adapter'] = function () {
    $client = new S3Client([
        'version' => 'latest',
        'region' => 'eu-west-2',
        'endpoint' => $_ENV['MINIO_ENDPOINT'],
        'use_path_style_endpoint' => true,
        'credentials' => [
            'key' => $_ENV['MINIO_ACCESS_KEY'],
            'secret' => $_ENV['MINIO_SECRET_KEY'],
        ],
    ]);

    return new AwsS3V3Adapter($client, $_ENV['MINIO_BUCKET']);
};
