<?php

namespace App\Repository;

use App\Entity\StatutTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatutTransaction>
 *
 * @method StatutTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutTransaction[]    findAll()
 * @method StatutTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutTransaction::class);
    }

    //    /**
    //     * @return StatutTransaction[] Returns an array of StatutTransaction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?StatutTransaction
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
