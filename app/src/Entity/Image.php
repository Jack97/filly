<?php

namespace App\Entity;

class Image
{
    public int $id;
    public string $fileName;
    public int $width;
    public int $height;
    public int $focalPointX;
    public int $focalPointY;

    public function __construct(array $data)
    {
        $this->fileName = $data['file_name'];
        $this->width = $data['width'];
        $this->height = $data['height'];
        $this->focalPointX = $data['focal_point_x'] ?? 0;
        $this->focalPointY = $data['focal_point_y'] ?? 0;
    }
}
