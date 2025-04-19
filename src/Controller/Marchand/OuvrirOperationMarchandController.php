<?php

namespace App\Controller\Marchand;

use App\Repository\UserRepository;
use App\Service\UtilisateurService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER')]
class OuvrirOperationMarchandController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository)
    {  
    }

    #[Route('/ouvrir-operation-marchand', name: 'ouvrir_opmarchand')]
    public function ouvrirOpMarchand(Request $request): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        
        $comptemarchand = $this->userRepository->findOneBy([
            'slug' => $request->request->get('opmarchand'),
        ]);
        return $this->render('Marchand/operationMarchand.html.twig', [
            'comptemarchand' => $comptemarchand,
        ]);
    }
}
