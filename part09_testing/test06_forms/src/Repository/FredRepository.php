<?php

namespace App\Repository;

use App\Entity\Fred;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fred>
 *
 * @method Fred|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fred|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fred[]    findAll()
 * @method Fred[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FredRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fred::class);
    }

    //    /**
    //     * @return Fred[] Returns an array of Fred objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fred
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
