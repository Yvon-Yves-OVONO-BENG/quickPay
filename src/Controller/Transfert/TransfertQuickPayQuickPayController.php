<?php

namespace App\Controller\Transfert;

use App\Entity\Transaction;
use App\Repository\PorteMonnaieRepository;
use App\Repository\UserRepository;
use App\Service\NumeroTransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class TransfertQuickPayQuickPayController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private PorteMonnaieRepository $porteMonnaieRepository,
        private NumeroTransactionService $numeroTransactionService,
    )
    {}

    #[Route('/transfert-quickPay-quickPay', name: 'transfert_quickPay_quickPay', methods: ['POST'])]
    public function transfertAjax(
        Request $request
    ): JsonResponse 
    {
        $numeroCompte = $request->request->get('numeroCompte');
        $montant = (float) $request->request->get('montantEnvoye');
        $codeTransaction = $request->request->get('codeTransaction');

        $user = $this->getUser();
        
        $expediteur = $this->userRepository->find($user->getId());

        // Récupération des porte-monnaies
        $porteMonnaieExpediteur = $this->porteMonnaieRepository->findOneBy(['user' => $expediteur]);
        $porteMonnaieDestinataire = $this->porteMonnaieRepository->findOneBy(['numeroCompte' => $numeroCompte]);
        $quickPackUser = $this->userRepository->findOneBy(['email' => 'quickpay@gmail.com']); // ou autre critère
        $porteMonnaieQuickPack = $this->porteMonnaieRepository->findOneBy(['user' => $quickPackUser]);
        
        
        if (!$porteMonnaieDestinataire) 
        {
            return new JsonResponse(['status' => 'error', 'message' => 'Numéro de compte invalide.']);
        }

        if (!$porteMonnaieExpediteur) 
        {
            return new JsonResponse(['status' => 'error', 'message' => 'Expéditeur sans porte-monnaie.']);
        }

        if (!$porteMonnaieQuickPack) 
        {
            return new JsonResponse(['status' => 'error', 'message' => 'Compte QuickPack introuvable.']);
        }

        if ($porteMonnaieExpediteur->getSolde() < $montant) 
        {
            return new JsonResponse(['status' => 'error', 'message' => 'Solde insuffisant.']);
        }
        
       
        if (!password_verify((string) $codeTransaction, $expediteur->getCode())) 
        {
            return new JsonResponse(['status' => 'error', 'message' => 'Code de transaction incorrect.']);
        }

        // Calcul de la commission avec un plafond à 5000
        $commission = round($montant * 0.01, 2);
        $commission = min($commission, 5000);

        $montantDestinataire = $montant - $commission;

        // Mise à jour des soldes
        $porteMonnaieExpediteur->setSolde($porteMonnaieExpediteur->getSolde() - $montant);
        $porteMonnaieDestinataire->setSolde($porteMonnaieDestinataire->getSolde() + $montantDestinataire);
        $porteMonnaieQuickPack->setSolde($porteMonnaieQuickPack->getSolde() + $commission);

        // Enregistrement de la transaction
        $transaction = new Transaction();
        $transaction->setExpediteur($expediteur)
                    ->setDestinataire($porteMonnaieDestinataire->getUser())
                    ->setMontant($montantDestinataire)
                    ->setFraisTransaction($commission)
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setNumeroTransaction($this->numeroTransactionService->genererNumeroTransaction());

        $this->em->persist($transaction);
        $this->em->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Transfert effectué avec succès.']);
    }
}
