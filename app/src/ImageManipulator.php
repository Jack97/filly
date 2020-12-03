<?php

namespace App;

use App\Model\Image;
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
        $scale = min($image->getWidth() / $width, $image->getHeight() / $height);

        $cropWidth = max(1, (int) round($width * $scale));
        $cropHeight = max(1, (int) round($height * $scale));

        $cropX = $image->getFocalPointX() - (int) ($cropWidth / 2);

        if ($cropX < 0) {
            $cropX = 0;
        } elseif ($cropX + $cropWidth > $image->getWidth()) {
            $cropX = $image->getWidth() - $cropWidth;
        }

        $cropY = $image->getFocalPointY() - (int) ($cropHeight / 2);

        if ($cropY < 0) {
            $cropY = 0;
        } elseif ($cropY + $cropHeight > $image->getHeight()) {
            $cropY = $image->getHeight() - $cropHeight;
        }

        return $this->imageManager
            ->make($this->filesystem->readStream($image->getFileName()))
            ->crop($cropWidth, $cropHeight, $cropX, $cropY)
            ->resize($width, $height)
            ->response('jpg');
    }
}
