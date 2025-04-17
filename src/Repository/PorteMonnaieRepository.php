<?php

namespace App\Repository;

use App\Entity\PorteMonnaie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PorteMonnaie>
 *
 * @method PorteMonnaie|null find($id, $lockMode = null, $lockVersion = null)
 * @method PorteMonnaie|null findOneBy(array $criteria, array $orderBy = null)
 * @method PorteMonnaie[]    findAll()
 * @method PorteMonnaie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PorteMonnaieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PorteMonnaie::class);
    }

    //    /**
    //     * @return PorteMonnaie[] Returns an array of PorteMonnaie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PorteMonnaie
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
