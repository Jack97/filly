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
            ->select(['id', 'file_name'])
            ->from('images')
            ->orderBy('rand()');

        $data = $query->execute()->fetchAssociative();

        $image = new Image();

        $image->setId($data['id']);
        $image->setFileName($data['file_name']);

        return $image;
    }
}
