<?php

namespace App\Repository;

use App\Entity\CategorieUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieUser>
 *
 * @method CategorieUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieUser[]    findAll()
 * @method CategorieUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieUser::class);
    }

    //    /**
    //     * @return CategorieUser[] Returns an array of CategorieUser objects
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

    //    public function findOneBySomeField($value): ?CategorieUser
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
