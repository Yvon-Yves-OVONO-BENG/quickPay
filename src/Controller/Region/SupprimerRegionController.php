<?php

namespace App\Controller\Region;

use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
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
#[Route('/region')]
class SupprimerRegionController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected TranslatorInterface $translator,
        protected RegionRepository $regionRepository
    ){}

    #[Route('/supprimer-region/{slug}', name: 'supprimer_region')]
    public function supprimerRegion(Request $request, string $slug): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('suppression', null);
        
        #je récupère la catégorie à supprimer
        $region = $this->regionRepository->findOneBySlug([
            'slug' => $slug
        ]);

        if ($region->isSupprime() == 1) 
        {
            #je prépare ma requete à la restauration
            $region->setSupprime(0);

            #j'exécute ma requete
            $this->em->flush();

            #j'affiche le message de confirmation
            $this->addFlash('info', $this->translator->trans('Region rétablie avec succès !'));
                
            #j'affecte 1 à ma variable pour afficher le message
            $maSession->set('misAjour', 1);

            #je retourne à la liste des catégories
            return $this->redirectToRoute('afficher_region', [ 'm' => 1 ]);

        } 
        else 
        {
            #je prépare ma requete à la suppression
            $region->setSupprime(1);

            #j'exécute ma requete
            $this->em->flush();

            #j'affiche le message de confirmation
            $this->addFlash('info', $this->translator->trans('Region supprimée avec succès !'));
                
            #j'affecte 1 à ma variable pour afficher le message
            $maSession->set('suppression', 1);

            #je retourne à la liste des catégories
            return $this->redirectToRoute('afficher_region', [ 's' => 1 ]);
        }
        
    }
}
