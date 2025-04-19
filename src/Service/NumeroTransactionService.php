<?php

namespace App\Service;

use App\Repository\PorteMonnaieRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;

class NumeroTransactionService
{
    public function __construct(
        private EntityManagerInterface $em,
        private TransactionRepository $transactionRepository
        ) {}

    
    public function genererNumeroTransaction(): string
    {
        #je récupère l'id de la dernière transaction
        $derniereTransaction = $this->transactionRepository->findOneBy([], ['id' => 'DESC']);

        $id = $derniereTransaction ? $derniereTransaction->getId() : 0;

        #la date du jour au format dmY
        $date = (new \Datetime())->format('dmY');

        #construction du Numéro
        return 'QP-'.$date.$id;
    }


}