<?php

namespace App\Tests;

use App\ImageManipulator;
use App\Model\Image;

class ImageManipulatorTest extends WebTestCase
{
    /**
     * @param Image $image
     * @param array $resizeDimensions
     * @param array $expectedBlackPixelCoordinates
     *
     * @test
     * @dataProvider resizeProvider
     */
    public function it_will_crop_the_image_around_its_focal_point(
        Image $image,
        array $resizeDimensions,
        array $expectedBlackPixelCoordinates
    ) {
        $imageManager = $this->app['image.manager'];

        $imageManipulator = new ImageManipulator(
            $this->app['flysystem'],
            $imageManager
        );

        [ $width, $height ] = $resizeDimensions;

        $imageContents = $imageManipulator
            ->getResizeResponse($image, $width, $height)
            ->getContent();

        [ $x, $y ] = $expectedBlackPixelCoordinates;

        $rgb = $imageManager->make($imageContents)->pickColor($x, $y);

        // The pixel won't be a true black because we're reducing the quality of the original image.
        // Therefore, we must calculate a confidence score to determine if the pixel was originally black.
        $this->assertGreaterThanOrEqual(0.95, $this->getBlackPixelConfidence($rgb));
    }

    /**
     * @return int[][]
     */
    public function resizeProvider(): array
    {
        // Todo: Add more test cases...

        $image = new Image();
        $image->setFileName('focal-point-10-10.jpg');
        $image->setWidth(25);
        $image->setHeight(25);
        $image->setFocalPointX(10);
        $image->setFocalPointY(10);

        return [
            // Odd width
            [
                $image,
                [15, $image->getHeight()],
                [7, $image->getFocalPointY()],
            ],
            // Even width
            [
                $image,
                [12, $image->getHeight()],
                [6, $image->getFocalPointY()],
            ],
            // Odd height
            [
                $image,
                [$image->getWidth(), 13],
                [$image->getFocalPointX(), 6],
            ],
            // Even height
            [
                $image,
                [$image->getWidth(), 10],
                [$image->getFocalPointX(), 5],
            ],
        ];
    }

    /**
     * @param array $rgb
     * @return float
     */
    protected function getBlackPixelConfidence(array $rgb): float
    {
        $greyscale = ($rgb[0] + $rgb[1] + $rgb[2]) / 3;

        $invertedGreyscale = 255 - $greyscale;

        return (float) ($invertedGreyscale / 255);
    }
}
