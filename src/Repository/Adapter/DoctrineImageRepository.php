<?php

namespace App\Repository\Adapter;

use App\Model\Image;
use App\Repository\ImageRepository;
use Doctrine\DBAL\Connection;

class DoctrineImageRepository implements ImageRepository
{
    protected Connection $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function getRandom(int $width, int $height): ?Image
    {
        $query = $this->database
            ->createQueryBuilder()
            ->select([
                'id', 'file_name', 'width', 'height',
                'focal_point_x', 'focal_point_y',
            ])
            ->from('images')
            ->orderBy('rand()');

        $data = $query->execute()->fetchAssociative();

        $image = new Image();

        $image->setId($data['id']);
        $image->setFileName($data['file_name']);
        $image->setWidth((int) $data['width']);
        $image->setHeight((int) $data['height']);
        $image->setFocalPointX((int) $data['focal_point_x']);
        $image->setFocalPointY((int) $data['focal_point_y']);

        return $image;
    }
}
