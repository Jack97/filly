<?php

namespace Api\Entity;

use Api\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $fileName;

    /**
     * @ORM\Column(type="integer")
     */
    private int $width;

    /**
     * @ORM\Column(type="integer")
     */
    private int $height;

    /**
     * @ORM\Column(type="integer")
     */
    private int $focalPointX;

    /**
     * @ORM\Column(type="integer")
     */
    private int $focalPointY;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getFocalPointX(): ?int
    {
        return $this->focalPointX;
    }

    public function setFocalPointX(int $focalPointX): self
    {
        $this->focalPointX = $focalPointX;

        return $this;
    }

    public function getFocalPointY(): ?int
    {
        return $this->focalPointY;
    }

    public function setFocalPointY(int $focalPointY): self
    {
        $this->focalPointY = $focalPointY;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'file_name' => $this->getFileName(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'focal_point_x' => $this->getFocalPointX(),
            'focal_point_y' => $this->getFocalPointY(),
        ];
    }
}
