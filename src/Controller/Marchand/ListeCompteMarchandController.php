<?php

namespace App\Controller\Marchand;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class ListeCompteMarchandController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository)
    {  
    }

    #[Route('/liste-compte-marchand', name: 'liste_marchand')]
    public function listeCompteMarchand(): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $comptemarchands = $this->userRepository->rechercheMarchand();
        return $this->render('Marchand/listeCompteMarchand.html.twig', [
            'comptemarchands' => $comptemarchands,
        ]);
    }
}
