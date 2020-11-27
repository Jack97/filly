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

    public function getRandom(): ?Image
    {
        if (($count = $this->getCount()) < 1) {
            return null;
        }

        $offset = rand(0, $count - 1);

        $query = $this->database
            ->createQueryBuilder()
            ->select([
                'images.id',
                'images.file_name',
                'images.width',
                'images.height',
                'images.focal_point_x',
                'images.focal_point_y',
            ])
            ->from('images')
            ->setFirstResult($offset)
            ->setMaxResults(1);

        if (($data = $query->execute()->fetchAssociative()) === false) {
            return null;
        }

        return $this->makeImage($data);
    }

    public function getCount(): int
    {
        $query = $this->database
            ->createQueryBuilder()
            ->select('count(1)')
            ->from('images');

        return (int) $query->execute()->fetchOne();
    }

    protected function makeImage(array $data): Image
    {
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
