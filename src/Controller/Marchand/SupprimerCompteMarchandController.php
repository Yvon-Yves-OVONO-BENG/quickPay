<?php

namespace App\Controller\Marchand;

use App\Repository\UserRepository;
use App\Service\UtilisateurService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER')]
class SupprimerCompteMarchandController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected TranslatorInterface $translator)
    {  
    }

    #[Route('/supprimer-compte-marchand/{slug}', name: 'supprimer_comptemarchand')]
    public function supprimerCompteMarchand(Request $request, string $slug): Response
    {
        /**
         * @var User
         */
        $user = $this->getUser();
        $comptemarchand = $this->userRepository->findOneBy([
            'slug' => $slug,
        ]);
        $this->addFlash('info', $this->translator->trans('Compte supprimé avec success !'));
        // dd($comptemarchand);
        $comptemarchands = $this->userRepository->rechercheMarchand();
        return $this->render('Marchand/listeCompteMarchand.html.twig', [
            'comptemarchands' => $comptemarchands,
            'deleteOperation' => true
        ]);

    }
}
