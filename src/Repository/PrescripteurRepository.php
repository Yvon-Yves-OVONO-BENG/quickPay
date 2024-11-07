<?php

namespace App\Repository;

use App\Entity\Prescripteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prescripteur>
 *
 * @method Prescripteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prescripteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prescripteur[]    findAll()
 * @method Prescripteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrescripteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prescripteur::class);
    }

    //    /**
    //     * @return Prescripteur[] Returns an array of Prescripteur objects
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

    //    public function findOneBySomeField($value): ?Prescripteur
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
