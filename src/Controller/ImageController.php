<?php

namespace App\Controller;

use App\ImageManipulator;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Response;

class ImageController
{
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
        if ($width <= 0 || $height <= 0 || $width > 2000 || $height > 2000) {
            return new Response('Invalid image size.', 400);
        }

        // Todo: Get best matching image. Closest aspect ratio, and closest in size...

        $image = $this->imageRepository->getRandom($width, $height);

        return $this->imageManipulator->getResizeResponse($image, $width, $height);
    }
}
