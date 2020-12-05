<?php

namespace App;

use App\Entity\Image;
use Intervention\Image\ImageManager;
use League\Flysystem\FilesystemReader;
use Symfony\Component\HttpFoundation\Response;

class ImageManipulator
{
    protected FilesystemReader $filesystem;
    protected ImageManager $imageManager;

    public function __construct(
        FilesystemReader $filesystem,
        ImageManager $imageManager
    ) {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
    }

    public function getResizeResponse(Image $image, int $width, int $height): Response
    {
        $scale = min($image->width / $width, $image->height / $height);

        $cropWidth = max(1, (int) round($width * $scale));
        $cropHeight = max(1, (int) round($height * $scale));

        $cropX = $image->focalPointX - (int) ($cropWidth / 2);

        if ($cropX < 0) {
            $cropX = 0;
        } elseif ($cropX + $cropWidth > $image->width) {
            $cropX = $image->width - $cropWidth;
        }

        $cropY = $image->focalPointY - (int) ($cropHeight / 2);

        if ($cropY < 0) {
            $cropY = 0;
        } elseif ($cropY + $cropHeight > $image->height) {
            $cropY = $image->height - $cropHeight;
        }

        return $this->imageManager
            ->make($this->filesystem->readStream($image->fileName))
            ->crop($cropWidth, $cropHeight, $cropX, $cropY)
            ->resize($width, $height)
            ->response('jpg');
    }
}
