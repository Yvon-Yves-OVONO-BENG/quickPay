<?php

namespace App\Controller\Utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SupprimerUtilisateurController extends AbstractController
{
    #[Route('/supprimer/utilisateur', name: 'app_supprimer_utilisateur')]
    public function index(): Response
    {
        return $this->render('supprimer_utilisateur/index.html.twig', [
            'licence' => 1,
            'controller_name' => 'SupprimerUtilisateurController',
        ]);
    }
}
