<?php

namespace App\Tests;

use App\Controller\ImageController;
use App\Entity\Image;
use App\Repository\ImageRepository;
use Mockery;

class ImageControllerTest extends WebTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $image = new Image();
        $image->setFileName('25x25.jpg');
        $image->setWidth(25);
        $image->setHeight(25);

        $imageRepository = Mockery::mock(ImageRepository::class);
        $imageRepository->shouldReceive('getRandom')->once()->andReturn($image);

        $this->app['image.repository'] = $imageRepository;
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @test
     * @dataProvider widthAndHeightProvider
     */
    public function it_will_return_an_image_with_the_given_width_and_height(int $width, int $height)
    {
        $client = $this->createClient();

        $client->request('GET', "/{$width}/{$height}");

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());

        $imageManager = $this->app['image.manager'];

        $convertedImage = $imageManager->make($response->getContent());

        $this->assertEquals($width, $convertedImage->width());
        $this->assertEquals($height, $convertedImage->height());
    }

    /**
     * @param int $width
     *
     * @test
     * @dataProvider widthProvider
     */
    public function it_will_return_a_square_image_when_given_only_a_width(int $width)
    {
        $client = $this->createClient();

        $client->request('GET', "/{$width}");

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());

        $imageManager = $this->app['image.manager'];

        $convertedImage = $imageManager->make($response->getContent());

        $this->assertEquals($width, $convertedImage->width());
        $this->assertEquals($width, $convertedImage->height());
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @test
     * @dataProvider invalidWidthAndHeightProvider
     */
    public function it_will_error_if_the_given_dimensions_are_invalid(int $width, int $height)
    {
        $client = $this->createClient();

        $client->request('GET', "/{$width}/{$height}");

        $response = $client->getResponse();

        $this->assertTrue($response->isClientError());
    }

    /**
     * @return int[][]
     */
    public function widthAndHeightProvider(): array
    {
        return [
            [1, 1],
            [ImageController::MAX_WIDTH, 1],
            [1, ImageController::MAX_HEIGHT],
            [ImageController::MAX_WIDTH, ImageController::MAX_HEIGHT],
        ];
    }

    /**
     * @return int[][]
     */
    public function widthProvider(): array
    {
        return [
            [1],
            [ImageController::MAX_WIDTH],
        ];
    }

    /**
     * @return int[][]
     */
    public function invalidWidthAndHeightProvider(): array
    {
        return [
            [0, 1],
            [1, 0],
            [ImageController::MAX_WIDTH + 1, 1],
            [1, ImageController::MAX_HEIGHT + 1],
        ];
    }
}
