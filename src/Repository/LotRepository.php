<?php

namespace App\Repository;

use DateTime;
use App\Entity\Lot;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Lot>
 *
 * @method Lot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lot[]    findAll()
 * @method Lot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lot::class);
    }

    public function lotPeriode(DateTime $dateDebut, DateTime $dateFin): array
    {
        $qb = $this->createQueryBuilder('l')
                ->andWhere('l.enregistreLeAt BETWEEN :dateDebut AND :dateFin')
                ->setParameter('dateDebut', $dateDebut)
                ->setParameter('dateFin', $dateFin)
                ->orderBy('l.reference', 'ASC')
            ;


        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Lot[] Returns an array of Lot objects
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

    //    public function findOneBySomeField($value): ?Lot
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
