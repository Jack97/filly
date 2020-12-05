<?php

namespace Api\Repository;

use Api\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function random(): ?Image
    {
        $count = $this->count([]);

        if ($count < 1) {
            return null;
        }

        $offset = rand(0, $count - 1);

        return $this->createQueryBuilder('image')
            ->setMaxResults(1)
            ->setFirstResult($offset)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
