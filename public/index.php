<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\HomeController;
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
        'host' => 'host.docker.internal',
        'dbname' => 'filly',
        'charset' => 'utf8',
    ],
]);
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../templates',
));

$app['filesystem'] = function () use ($app) {
    return new Filesystem(
        new LocalFilesystemAdapter(__DIR__ . '/../images')
    );
};

$app['intervention.image'] = function () {
    return new ImageManager();
};

$app['image.repository'] = function () use ($app) {
    return new DoctrineImageRepository($app['db']);
};

$app['image.manipulator'] = function () use ($app) {
    return new ImageManipulator(
        $app['filesystem'], $app['intervention.image']
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

$app->get('/{width}/{height}', 'image.controller:show')
    ->assert('width', '[0-9]+')
    ->assert('height', '[0-9]+')
    ->bind('image.show');

$app->run();
