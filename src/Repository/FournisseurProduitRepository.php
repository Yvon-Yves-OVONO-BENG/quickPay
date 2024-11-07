<?php

namespace App\Repository;

use App\Entity\FournisseurProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FournisseurProduit>
 *
 * @method FournisseurProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method FournisseurProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method FournisseurProduit[]    findAll()
 * @method FournisseurProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FournisseurProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FournisseurProduit::class);
    }

    //    /**
    //     * @return FournisseurProduit[] Returns an array of FournisseurProduit objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FournisseurProduit
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
