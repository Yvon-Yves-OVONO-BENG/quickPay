<?php

namespace App\Controller\Region;

use App\Entity\Region;
use App\Service\StrService;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('/region')]
class ModifierRegionController extends AbstractController
{
    public function __construct(
        private StrService $strService,
        private PaysRepository $paysRepository,
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private RegionRepository $regionRepository,
    )
    {}

    #[Route('/modifier-region', name: 'modifier_region', methods: ['GET', 'POST'])]
    public function modifierRegion(Request $request): Response
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
            $regionId = $request->query->get('region_id');

            $region = $this->regionRepository->find($regionId);

            $data = [
                'id' => $region->getId(),
                'pays_id' => $region->getPays()->getId(),
                'nom' => $region->getRegion()
            ];
           
            return new JsonResponse($data);
        } 
        elseif($request->isMethod('POST'))
        {
            $paysId = $request->request->get('pays_id');
            
            $regionId = $request->request->get('region_id');

            $region = $this->regionRepository->find($regionId);

            $pays = $this->paysRepository->find($paysId);

            $region = new Region;

            $region->setRegion($this->strService->strToUpper($region->getRegion()))
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
