<?php

namespace App\Controller\Marchand;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER')]
class ActiverDesactiverCompteMarchandController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected TranslatorInterface $translator)
    {  
    }

    #[Route('/activer-desactiver-compte-marchand', name: 'activer_desactivercomptemarchand')]
    public function activerDesactiverCompteMarchand(Request $request): JsonResponse
    {
        /**
         * @var User
         */
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);
        $slug = $data['slug'] ?? null;
        $etat = $data['etat'] ?? null;
        $comptemarchand = $this->userRepository->findOneBy([
            'slug' => $slug,
        ]);
        
        if ($etat == 0) {
            $message = $this->translator->trans('Compte activé avec success !');
            $type = 'success';
        } else {
            $message = $this->translator->trans('Compte déactivé avec success !');
            $type = 'error';
        }
        ///afficher le message
        return new JsonResponse(['success' => true, 'message' => $message, 'type' => $type]);
    
    }
}
