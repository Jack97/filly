<?php

namespace App\Tests;

use App\Controller\ImageController;
use App\Model\Image;
use App\Repository\ImageRepository;
use Mockery;

class ImageControllerTest extends WebTestCase
{
    /** @test */
    public function it_will_return_an_image_with_the_given_dimensions()
    {
        $width = 10;
        $height = 10;

        $image = $this->makeImage();

        $imageRepository = Mockery::mock(ImageRepository::class);
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
    public function invalidDimensionsProvider(): array
    {
        return [
            [0, 10],
            [10, 0],
            [ImageController::MAX_WIDTH + 1, 10],
            [10, ImageController::MAX_HEIGHT + 1],
        ];
    }

    protected function makeImage()
    {
        $image = new Image();

        $image->setFileName('1.jpg');
        $image->setWidth(500);
        $image->setHeight(375);
        $image->setFocalPointX(0);
        $image->setFocalPointY(0);

        return $image;
    }
}
