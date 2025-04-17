<?php

namespace App\Repository;

use App\Entity\DemandeModificationMotDePasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeModificationMotDePasse>
 *
 * @method DemandeModificationMotDePasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeModificationMotDePasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeModificationMotDePasse[]    findAll()
 * @method DemandeModificationMotDePasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeModificationMotDePasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeModificationMotDePasse::class);
    }

    //    /**
    //     * @return DemandeModificationMotDePasse[] Returns an array of DemandeModificationMotDePasse objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DemandeModificationMotDePasse
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
