<?php

namespace App\Controller\Utilisateur;

use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AfficherUtilisateurController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {}

    #[Route('/afficher-utilisateur/{a<[0-1]{1}>}/{m<[0-1]{1}>}/{s<[0-1]{1}>}', name: 'afficher_utilisateur')]
    public function afficherUtilisateur(Request $request, int $a = 0, int $m = 0, int $s = 0): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();

        if(!$maSession)
        {
            return $this->redirectToRoute("app_logout");
        }

        if ($a == 1 || $m == 0 || $s == 0) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', null);
            $maSession->set('suppression', null);
            
        }

        #je teste si le témoin n'est pas vide pour savoir s'il vient de la mise à jour
        if ($m == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', 1);
            $maSession->set('suppression', null);
            
        }

        #je teste si le témoin n'est pas vide pour savoir s'il vient de la suppression
        
        if ($s == 1) 
        {
            #mes variables témoin pour afficher les sweetAlert
            $maSession->set('ajout', null);
            $maSession->set('misAjour', null);
            $maSession->set('suppression', 1);
            
        }
        
        # je récupère tous les utilisateurs
        $tousLesUtilisateurs = $this->userRepository->findAll();

        $utilisateurs = array_filter($tousLesUtilisateurs, function($utilisateur)
        {
            return !in_array('ROLE_SUPER_ADMINISTRATEUR', $utilisateur->getRoles());
        });
        
        return $this->render('utilisateur/afficherUtilisateur.html.twig', [
            'licence' => 1,
            'utilisateurs' => $utilisateurs
        ]);
    }
}
