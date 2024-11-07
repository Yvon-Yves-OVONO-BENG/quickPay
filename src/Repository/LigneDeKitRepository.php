<?php

namespace App\Repository;

use App\Entity\LigneDeKit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneDeKit>
 *
 * @method LigneDeKit|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneDeKit|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneDeKit[]    findAll()
 * @method LigneDeKit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneDeKitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneDeKit::class);
    }

    //    /**
    //     * @return LigneDeKit[] Returns an array of LigneDeKit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LigneDeKit
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
