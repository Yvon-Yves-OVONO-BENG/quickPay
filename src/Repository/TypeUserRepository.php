<?php

namespace App\Repository;

use App\Entity\TypeUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeUser>
 *
 * @method TypeUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeUser[]    findAll()
 * @method TypeUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeUser::class);
    }

    //    /**
    //     * @return TypeUser[] Returns an array of TypeUser objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TypeUser
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
