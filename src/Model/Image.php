<?php

namespace App\Model;

class Image
{
    protected int $id;
    protected string $fileName;
    protected int $width;
    protected int $height;
    protected int $focalPointX = 0;
    protected int $focalPointY = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getFocalPointX(): int
    {
        return $this->focalPointX;
    }

    public function setFocalPointX(int $x): self
    {
        $this->focalPointX = $x;

        return $this;
    }

    public function getFocalPointY(): int
    {
        return $this->focalPointY;
    }

    public function setFocalPointY(int $y): self
    {
        $this->focalPointY = $y;

        return $this;
    }
}
