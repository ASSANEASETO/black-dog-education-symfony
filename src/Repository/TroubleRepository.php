<?php

namespace App\Repository;

use App\Entity\Trouble;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trouble>
 */
class TroubleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trouble::class);
    }
    // Example custom query method
    // public function findServiceByCategory($category)
    // {
    //     return $this->createQueryBuilder('t')
    //         ->andWhere('t.category = :category')
    //         ->setParameter('category', $category)
    //         ->getQuery()
    //         ->getResult();
    // }
    //    /**
    //     * @return Trouble[] Returns an array of Trouble objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Trouble
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
