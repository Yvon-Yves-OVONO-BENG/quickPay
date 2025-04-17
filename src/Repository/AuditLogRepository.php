<?php

namespace App\Repository;

use DateTime;
use App\Entity\AuditLog;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AuditLog>
 *
 * @method AuditLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditLog[]    findAll()
 * @method AuditLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditLog::class);
    }

    /**
     * méthode qui me retourne les audit d'une période
     *
     * @param DateTime $dateDebut
     * @param DateTime $dateFin
     * @return array
     */
    public function getAuditLogPeriode(DateTime $dateDebut, DateTime $dateFin): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('(a.dateActionAt BETWEEN :dateDebut AND :dateFin) OR
            (a.dateActionAt BETWEEN :dateDebut AND :dateFin) OR 
            (a.dateActionAt <= :dateDebut AND a.dateActionAt >= :dateFin)')
            ->setParameter('dateDebut', $dateDebut->format('Y-m-d'))
            ->setParameter('dateFin', $dateFin->format('Y-m-d'))
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * les audits
     *
     * @return array
     */
    public function getAuditLog(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function getAuditUserPeriode(int $user, DateTime $dateDebut, DateTime $dateFin): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->andWhere('(a.dateActionAt BETWEEN :dateDebut AND :dateFin) OR
            (a.dateActionAt BETWEEN :dateDebut AND :dateFin) OR 
            (a.dateActionAt <= :dateDebut AND a.dateActionAt >= :dateFin)')
            ->setParameter('dateDebut', $dateDebut->format('Y-m-d'))
            ->setParameter('dateFin', $dateFin->format('Y-m-d'))
            ->setParameter('user', $user)
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * les six dernières connexion
     *
     * @return array
     */
    public function getLesSixDernieresConnexion(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return AuditLog[] Returns an array of AuditLog objects
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

    //    public function findOneBySomeField($value): ?AuditLog
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
