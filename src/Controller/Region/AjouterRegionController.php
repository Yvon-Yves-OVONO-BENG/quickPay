<?php

namespace App\Controller\Region;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\PaysRepository;
use App\Service\StrService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('region')]
class AjouterRegionController extends AbstractController
{
    public function __construct(
        private StrService $strService,
        private EntityManagerInterface $em,
        private PaysRepository $paysRepository,
        private TranslatorInterface $translator,
    )
    {}

    #[Route('/ajouter-region', name: 'ajouter_region', methods: ['GET', 'POST'])]
    public function ajouterRegion(Request $request): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('misAjour', null);
        $maSession->set('suppression', null);

        if (!$this->getUser()) 
        {
            return $this->redirectToRoute('app_logout');
        }

        if ($request->isMethod('GET')) 
        {
            $pays = $this->paysRepository->findAll();

            return $this->render('region/ajouterRegion.html.twig', [
                'slug' => 0,
                'licence' => 1,
                'pays' => $pays,
            ]);
        } 
        elseif($request->isMethod('POST'))
        {
            $paysId = $request->request->get('pays_id');
            $nomRegion = $request->request->get('nom_region');

            $pays = $this->paysRepository->find($paysId);

            $region = new Region;

            $region->setRegion($this->strService->strToUpper($nomRegion))
            ->setPays($pays)
            ->setSlug(uniqid('', true))
            ->setSupprime(0);

            $this->em->persist($region);
            $this->em->flush();

            return new JsonResponse(['success' => true ]);
        }

        return $this->render('region/ajouterRegion.html.twig', [
            'licence' => 1,
        ]);
    }
}
