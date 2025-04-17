<?php

namespace App\Service;

use App\Repository\TransactionRepository;
use App\Repository\UserRepository;

class UtilisateurService
{
    public function __construct(
        private UserRepository $userRepository,
        private TransactionRepository $transactionRepository
        ){}


    public function getStatistiquesParUtilisateur(int $userId)
    {
        $statistiques = $this->transactionRepository->getStatistiquesParUtilisateur($userId);

        return $statistiques;
    }


    public function findTransactionParUtilisateur(int $userId)
    {
        $toutesLesTransactions = $this->transactionRepository->findTransactionParUtilisateur($userId);

        return $toutesLesTransactions;
    }


    public function transactionsRecus(int $userId)
    {
        $user = $this->userRepository->find($userId);

        $transactionsRecus = $this->transactionRepository->findBy([
            'destinataire' => $user
        ], ['createdAt' => 'DESC']);

        return $transactionsRecus;
    }


    public function transactionsEnvoyes(int $userId)
    {
        $user = $this->userRepository->find($userId);
        
        $transactionsEnvoyes = $this->transactionRepository->findBy([
            'expediteur' => $user
        ], ['createdAt' => 'DESC']);

        return $transactionsEnvoyes;
    }

  
}

