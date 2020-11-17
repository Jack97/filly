<?php

namespace App\Model;

class Image
{
    protected int $id;

    protected string $fileName;

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
        // Todo

        return 500;
    }

    public function getHeight(): int
    {
        // Todo

        return 375;
    }

    public function getFocalPointX(): int
    {
        // Todo

        return 0;
    }

    public function getFocalPointY(): int
    {
        // Todo

        return 0;
    }
}
