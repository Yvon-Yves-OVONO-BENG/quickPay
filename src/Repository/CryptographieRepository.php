<?php

namespace App\Repository;

use App\Entity\Cryptographie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cryptographie>
 *
 * @method Cryptographie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cryptographie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cryptographie[]    findAll()
 * @method Cryptographie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptographieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cryptographie::class);
    }

    //    /**
    //     * @return Cryptographie[] Returns an array of Cryptographie objects
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

    //    public function findOneBySomeField($value): ?Cryptographie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
