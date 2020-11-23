<?php

namespace App\Tests;

use App\Controller\ImageController;
use App\Model\Image;
use App\Repository\ImageRepository;
use Mockery;

class ImageControllerTest extends WebTestCase
{
    /**
     * @param int $width
     * @param int $height
     *
     * @test
     * @dataProvider dimensionsProvider
     */
    public function it_will_return_an_image_with_the_given_dimensions(int $width, int $height)
    {
        $imageRepository = Mockery::mock(ImageRepository::class);

        $image = new Image();

        $image->setFileName('image.jpg');
        $image->setWidth(21);
        $image->setHeight(21);

        $imageRepository->shouldReceive('getRandom')->once()->andReturn($image);

        $this->app['image.repository'] = $imageRepository;

        $client = $this->createClient();

        $client->request('GET', "/{$width}/{$height}");

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());

        $convertedImage = $this->app['image.manager']->make(
            $response->getContent()
        );

        $this->assertEquals($width, $convertedImage->width());
        $this->assertEquals($height, $convertedImage->height());
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @test
     * @dataProvider invalidDimensionsProvider
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
    public function dimensionsProvider(): array
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
    public function invalidDimensionsProvider(): array
    {
        return [
            [0, 1],
            [1, 0],
            [ImageController::MAX_WIDTH + 1, 1],
            [1, ImageController::MAX_HEIGHT + 1],
        ];
    }
}
