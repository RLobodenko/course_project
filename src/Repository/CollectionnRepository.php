<?php

namespace App\Repository;

use App\Entity\Collectionn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Collectionn>
 */
class CollectionnRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collectionn::class);
    }
    
    /**
     * Find the largest collections by item count
     *
     * @param int $limit
     * @return Collection[]
     */
    public function findLargestCollections(int $limit): array
    {
        return $this->createQueryBuilder('c')
            ->select('c, COUNT(i.id) as HIDDEN itemCount')
            ->leftJoin('c.items', 'i')
            ->groupBy('c.id')
            ->orderBy('itemCount', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Collectionn[] Returns an array of Collectionn objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Collectionn
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
