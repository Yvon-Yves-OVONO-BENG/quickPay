<?php

namespace App\Controller\Utilisateur;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/utilisateur')]
class ActiverUtilisateurController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected TranslatorInterface $translator,
        protected UserRepository $utilisateurRepository
    )
    {}

    #[Route('/activer-utilisateur', name: 'activer_utilisateur', methods: 'POST')]
    public function activerUtilisateur(Request $request): JsonResponse
    {
        # je récupère ma session
        $maSession = $request->getSession();

        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('suppression', null);
        
        $utilisateurId = (int)$request->request->get('utilisateur_id');
        
        $utilisateur = $this->utilisateurRepository->find($utilisateurId);
        
        if ($utilisateur->isEtat() == 0) 
        {
            $utilisateur->setEtat(1);
        } 
        else 
        {
            $utilisateur->setEtat(0);
        }
        
        #je prépare ma requête à la suppression
        $this->em->persist($utilisateur);

        #j'exécute ma requête
        $this->em->flush();

        #je retourne à la liste des catégories
        return new JsonResponse(['success' => true, 'etat' => $utilisateur->isEtat() ]);
    }
}
