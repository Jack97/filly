<?php

namespace Api;

use Api\Controller\ImageController;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new \Symfony\Bundle\MakerBundle\MakerBundle(),
        ];
    }

    public function configureContainer(ContainerConfigurator $container)
    {
        $container->import(__DIR__ . '/../config/config.yaml');

        $container
            ->services()
            ->load('Api\\', __DIR__ . '/*')
            ->autowire()
            ->autoconfigure();
    }

    public function configureRoutes(RoutingConfigurator $routes)
    {
        $routes
            ->add('images.random', '/images/random')
            ->controller([ImageController::class, 'random'])
            ->methods(['GET']);
    }
}
