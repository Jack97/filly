<?php

namespace App\Tests;

use App\Entity\Image;
use App\Repository\Adapter\DoctrineImageRepository;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class DoctrineImageRepositoryTest extends WebTestCase
{
    protected function setUp()
    {
        parent::setUp();

        // We're using an in-memory database for testing, so all we
        // need to do is re-migrate the database before each test...

        // Required by the console bootstrapper...
        $app = $this->app;

        /** @var Console $console */
        $console = require __DIR__ . '/../bootstrap/console.php';
        $console->setAutoExit(false);

        $migrateInput = new ArrayInput(['command' => 'migrations:migrate']);
        $migrateInput->setInteractive(false);

        $console->run($migrateInput, new NullOutput());
    }

    /** @test */
    public function it_can_fetch_a_random_image()
    {
        /** @var Connection $database */
        $database = $this->app['db'];

        $fileName = 'image.jpg';
        $width = 25;
        $height = 25;
        $focalPointX = 12;
        $focalPointY = 12;

        // Insert a fake image into the database...
        $database
            ->createQueryBuilder()
            ->insert('images')
            ->values($values = [
                'file_name' => "'${fileName}'",
                'width' => $width,
                'height' => $height,
                'focal_point_x' => $focalPointX,
                'focal_point_y' => $focalPointY,
            ])
            ->execute();

        $imageRepository = new DoctrineImageRepository($database);

        $image = $imageRepository->getRandom();

        $this->assertInstanceOf(Image::class, $image);

        $this->assertEquals($fileName, $image->getFileName());
        $this->assertEquals($width, $image->getWidth());
        $this->assertEquals($height, $image->getHeight());
        $this->assertEquals($focalPointX, $image->getFocalPointX());
        $this->assertEquals($focalPointY, $image->getFocalPointY());
    }
}
