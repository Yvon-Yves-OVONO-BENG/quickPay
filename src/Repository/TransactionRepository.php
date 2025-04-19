<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 *
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * fonction qui retourne les statistiques d'un utilisateur
     *
     * @param integer $userId
     * @return array
     */
    public function getStatistiquesParUtilisateur(int $userId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT COUNT(*) AS totalTransactionUtilisateur, SUM(montant) AS montantTotalutilisateur,
        
        COUNT(CASE WHEN destinataire_id = :userId THEN 1 END) AS totalReception,
        SUM(CASE WHEN destinataire_id = :userId THEN montant ELSE 0 END) AS montantRecu,
        
        COUNT(CASE WHEN expediteur_id = :userId THEN 1 END) AS totalEnvoie,
        SUM(CASE WHEN expediteur_id = :userId THEN montant ELSE 0 END) AS montantEnvoye
        
        FROM transaction 
        WHERE expediteur_id = :userId OR destinataire_id = :userId";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);

        return $resultSet->fetchAssociative();
    }

    public function findTransactionParUtilisateur(int $userId): array
    {
        return $this->createQueryBuilder('t')
                    ->where('t.expediteur = :userId')
                    ->orWhere('t.destinataire = :userId')
                    ->setParameter('userId', $userId)
                    ->orderBy('t.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    //    /**
    //     * @return Transaction[] Returns an array of Transaction objects
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

    //    public function findOneBySomeField($value): ?Transaction
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
