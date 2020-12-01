<?php

use App\Controller\HomeController;
use App\Controller\ImageController;
use App\ImageManipulator;
use App\Repository\Adapter\DoctrineImageRepository;
use Intervention\Image\ImageManager;
use League\Flysystem\Filesystem;
use Silex\Application;

$app = new Application();

$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);

$app['filesystem'] = function () use ($app) {
    return new Filesystem($app['filesystem.adapter']);
};

$app['image.manager'] = function () use ($app) {
    return new ImageManager([
        'driver' => $app['image.manager.driver'],
    ]);
};

$app['image.repository'] = function () use ($app) {
    return new DoctrineImageRepository($app['db']);
};

$app['image.manipulator'] = function () use ($app) {
    return new ImageManipulator(
        $app['filesystem'], $app['image.manager']
    );
};

$app['home.controller'] = function () use ($app) {
    return new HomeController($app['twig']);
};

$app['image.controller'] = function () use ($app) {
    return new ImageController(
        $app['image.repository'], $app['image.manipulator']
    );
};

$app->get('/', 'home.controller:index')
    ->bind('homepage');

$app->get('/{width}', 'image.controller:show')
    ->assert('width', '[0-9]+')
    ->bind('image.square');

$app->get('/{width}/{height}', 'image.controller:show')
    ->assert('width', '[0-9]+')
    ->assert('height', '[0-9]+')
    ->bind('image.rectangle');

return $app;
