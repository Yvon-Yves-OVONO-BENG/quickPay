<?php

namespace App\Controller\Region;

use App\Entity\ConstantsClass;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('region')]

class AfficherRegionController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator,
        private PaysRepository $paysRepository,
        private RegionRepository $regionRepository,
    )
    {}

    #[Route('/afficher-region/{a<[0-1]{1}>}/{m<[0-1]{1}>}/{s<[0-1]{1}>}', name: 'afficher_region')]
    public function afficherRegion(Request $request, int $a = 0, int $m = 0, int $s = 0): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();

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
        
        if ($this->getUser() && in_array(ConstantsClass::ROLE_ADMINISTRATEUR, $this->getUser()->getRoles())) 
        {
            #je récupère toutes les regions
            $regions = $this->regionRepository->findBy([
            ], ['region' => 'ASC']);

            #je récupère les pays
            $pays = $this->paysRepository->findAll();
        } 
        elseif ($this->getUser() && in_array(ConstantsClass::ROLE_GESTIONNAIRE, $this->getUser()->getRoles())) 
        {
            #je récupère toutes les regions
            $regions = $this->regionRepository->findBy([
                'supprime' => 0
            ]);
        }
        
        #j'envoie mon tableau des regions à mon rendu twig pour affichage
        return $this->render('region/afficherRegion.html.twig', [
            'licence' => 1,
            'pays' => $pays,
            'regions' => $regions,
        ]);
    }
}
