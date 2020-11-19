<?php

namespace App\Controller;

use App\ImageManipulator;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Response;

class ImageController
{
    const MAX_WIDTH = 2000;
    const MAX_HEIGHT = 2000;

    protected ImageRepository $imageRepository;
    protected ImageManipulator $imageManipulator;

    public function __construct(
        ImageRepository $imageRepository,
        ImageManipulator $imageManipulator
    ) {
        $this->imageRepository = $imageRepository;
        $this->imageManipulator = $imageManipulator;
    }

    public function show(int $width, int $height): Response
    {
        if (
            $width <= 0 ||
            $height <= 0 ||
            $width > self::MAX_WIDTH ||
            $height > self::MAX_HEIGHT
        ) {
            return new Response('Invalid image size.', 400);
        }

        $image = $this->imageRepository->getRandom($width, $height);

        return $this->imageManipulator
            ->getResizeResponse($image, $width, $height)
            ->setPublic()
            ->setMaxAge(86400);
    }
}
