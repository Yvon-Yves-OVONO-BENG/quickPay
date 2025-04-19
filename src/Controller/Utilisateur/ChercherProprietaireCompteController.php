<?php

namespace App\Controller\Utilisateur;

use App\Repository\PorteMonnaieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ChercherProprietaireCompteController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private PorteMonnaieRepository $porteMonnaieRepository
    )
    {}

    #[Route('/chercher-proprietaire-compte', name: 'chercher_proprietaire_compte', methods: ['POST'])]
    public function chercherProprietaireCompte(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $numeroCompte = $data['numeroCompte'] ?? null;
        
        if (!$numeroCompte) 
        {
            return new JsonResponse(['error' => 'Numéro de compte introuvable'], 400);
        }

        #je cherche le porte monnaie dont le numéro de compte est fourni
        $porteMonnaie = $this->porteMonnaieRepository->findOneBy([
            'numeroCompte' => $numeroCompte,
        ]);

        if ($porteMonnaie && $porteMonnaie->getUser()) 
        {
            $nom = strtoupper($porteMonnaie->getUser()->getUsername());

            return new JsonResponse([
                'nom' => strtoupper($porteMonnaie->getUser()->getUsername()), 
                'numCni' => $porteMonnaie->getUser()->getNumCni()
            ]);
        }

         return new JsonResponse(['nom' => null ]);
    }
}
