<?php

namespace App\Repository;

use DateTime;
use App\Entity\HistoriquePaiement;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<HistoriquePaiement>
 *
 * @method HistoriquePaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriquePaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriquePaiement[]    findAll()
 * @method HistoriquePaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriquePaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriquePaiement::class);
    }

    public function avancesDuJour(DateTime $dateJour): array
    {
        $qb = $this->createQueryBuilder('h')
            ->andWhere('h.dateAvanceAt =:dateJour')
            ->setParameter('dateJour', $dateJour)
            ;
            
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return HistoriquePaiement[] Returns an array of HistoriquePaiement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?HistoriquePaiement
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
