<?php

namespace App\Controller\Transaction;

use App\Service\UtilisateurService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class TransactionController extends AbstractController
{
    #[Route('/transaction/{r<[0-1]{1}>}/{e<[0-1]{1}>}/{t<[0-1]{1}>}', name: 'transaction')]
    public function transaction(UtilisateurService $utilisateurService, int $r = 0, int $e = 0, int $t = 0): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        
        if ($r == 1) 
        {
            #les transactions recus
            $transactions = $utilisateurService->transactionsRecus($user->getId());
        }

        if ($e == 1) 
        {
            #les transactions envoyés
            $transactions = $utilisateurService->transactionsEnvoyes($user->getId());
        }

        if ($t == 1) 
        {
            #Toutes les transactions
            $transactions = $utilisateurService->findTransactionParUtilisateur($user->getId());
        }

        return $this->render('transaction/transaction.html.twig', [
            'r' => $r,
            'e' => $e,
            't' => $t,
            'transactions' => $transactions,
        ]);
    }
}
