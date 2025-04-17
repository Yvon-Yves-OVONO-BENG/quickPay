<?php

namespace App\Controller\PorteFeuille;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class AjouterArgentController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserRepository $userRepository,
        protected CsrfTokenManagerInterface $csrfTokenManager,
    )
    {}

    #[Route('/ajouter-argent', name: 'ajouter_argent')]
    public function ajouterArgent(): Response
    {
        # je crée mon CSRF pour sécuriser mes formulaires
        $csrfToken = $this->csrfTokenManager->getToken('ajouterArgent')->getValue();

        return $this->render('porteFeuille/ajouter_argent.html.twig', [
            
        ]);
    }
}
