<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\ImageController;
use App\ImageManipulator;
use App\Repository\Adapter\DoctrineImageRepository;
use Intervention\Image\ImageManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Silex\Application;

$app = new Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => [
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'dbname' => 'filly',
        'charset' => 'utf8',
    ],
]);
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app['filesystem'] = function () use ($app) {
    return new Filesystem(
        new LocalFilesystemAdapter(__DIR__ . '/../images')
    );
};

$app['images.repository'] = function () use ($app) {
    return new DoctrineImageRepository($app['db']);
};

$app['images.manipulator'] = function () use ($app) {
    return new ImageManipulator($app['filesystem'], new ImageManager());
};

$app['images.controller'] = function () use ($app) {
    return new ImageController($app['images.repository'], $app['images.manipulator']);
};

$app->get('/{width}/{height}', 'images.controller:show')
    ->assert('width', '[0-9]+')
    ->assert('height', '[0-9]+');

$app->run();
