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
class CrediterCompteMarchandController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository)
    {  
    }

    #[Route('/crediter-compte-marchand', name: 'crediter_comptemarchand')]
    public function crediterCompteMarchand(Request $request): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $comptemarchand = $this->userRepository->findOneBy([
            'slug' => $request->request->get('slug'),
        ]);
        dd($comptemarchand);
        return $this->render('Marchand/operationMarchand.html.twig', [
            'comptemarchand' => $comptemarchand,
        ]);
    }
}
