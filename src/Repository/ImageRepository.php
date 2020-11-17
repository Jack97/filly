<?php

namespace App\Repository;

use App\Model\Image;

interface ImageRepository
{
    public function getRandom(int $width, int $height): ?Image;
}
