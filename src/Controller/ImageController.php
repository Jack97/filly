<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Response;

class ImageController
{
    protected ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function show(int $width, int $height): Response
    {
        // Todo: Verify width and height, not 0 or too large...
        // Todo: Get best matching image. Closest aspect ratio, and closest in size...

        $image = $this->imageRepository->getRandom($width, $height);

        $scale = min($image->getWidth() / $width, $image->getHeight() / $height);

        $cropWidth = (int) ($width * $scale);
        $cropHeight = (int) ($height * $scale);

        $focalPointX = 240;
        $focalPointY = 100;

        $cropX = $focalPointX - (int) ceil($cropWidth / 2);

        if ($cropX < 0) {
            $cropX = 0;
        } elseif ($cropX + $cropWidth > $image->getWidth()) {
            $cropX = $image->getWidth() - $cropWidth;
        }

        $cropY = $focalPointY - (int) ceil($cropHeight / 2);

        if ($cropY < 0) {
            $cropY = 0;
        } elseif ($cropY + $cropHeight > $image->getHeight()) {
            $cropY = $image->getHeight() - $cropHeight;
        }

        $imageManager = new ImageManager();

        $image = $imageManager
            ->make(__DIR__ . "/../../images/{$image->getFileName()}")
            ->crop($cropWidth, $cropHeight, $cropX, $cropY)
            ->resize($width, $height);

        return $image->response('jpg');
    }
}
