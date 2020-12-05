<?php

namespace App\Controller;

use App\ImageClient;
use App\ImageManipulator;
use Symfony\Component\HttpFoundation\Response;

class ImageController
{
    const MAX_WIDTH = 2000;
    const MAX_HEIGHT = 2000;

    protected ImageClient $imageClient;
    protected ImageManipulator $imageManipulator;

    public function __construct(
        ImageClient $imageClient,
        ImageManipulator $imageManipulator
    ) {
        $this->imageClient = $imageClient;
        $this->imageManipulator = $imageManipulator;
    }

    public function show(int $width, int $height = null): Response
    {
        $height ??= $width;

        if (
            $width <= 0 ||
            $height <= 0 ||
            $width > self::MAX_WIDTH ||
            $height > self::MAX_HEIGHT
        ) {
            return new Response('Invalid image size.', 400);
        }

        $image = $this->imageClient->fetchRandom();

        return $this->imageManipulator
            ->getResizeResponse($image, $width, $height)
            ->setPublic()
            ->setMaxAge(86400); // 1 day
    }
}
