<?php

namespace App\Controller\Facture;

use App\Entity\HistoriquePaiement;
use App\Form\AjoutAvanceType;
use App\Repository\EtatFactureRepository;
use App\Repository\FactureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
class AjoutAvanceController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected FactureRepository $factureRepository,
        protected EtatFactureRepository $etatFactureRepository,
    )
    {}

    #[Route('/ajout-avance/{slug}', name: 'ajout_avance')]
    public function ajoutAvance(Request $request, $slug): Response
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('suppression', null);

        #je récupère la facture dont je veux ajouter l'avance
        $facture = $this->factureRepository->findOneBySlug([
            'slug' => $slug
        ]);

        #je récupère le reste
        $reste = $facture->getNetAPayer() - $facture->getAvance();
            
        // 1. Nous voulons lire les données du formulaire
        //FormFactoryInterface / Request
        $form = $this->createForm(AjoutAvanceType::class, null, ['reste' => $reste]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $facture = $this->factureRepository->findOneBySlug([
                'slug' => $request->request->get('slugFacture')
            ]);

            $avanceActuelle = $facture->getAvance();
            $avance = $form->getData()->getAvance();
            
            $nouvelleAvance = $avanceActuelle + $avance;
            
            #je met à jour l'avance dans la tale facture
            $facture->setAvance($nouvelleAvance)
            ->setDateFactureAt(new DateTime('now'))
            ->setHeure(new DateTime('now'))
            ;

            ######j'insère une nouvelle ligne dans la table historique paiement
            $historiquePaiement = new HistoriquePaiement;

            $historiquePaiement->setFacture($facture)
            ->setMontantAvance($avance)
            ->setDateAvanceAt(new DateTime('now'))
            ->setRecuPar($this->getUser());

            ####SI LE NET A PAYER EST EGAL A LA NOUVELLE AVANCE, ON MET LA FACTURE A SOLDE
            if ($facture->getNetApayer() == $nouvelleAvance) 
            {
                $facture->setEtatFacture($this->etatFactureRepository->find(1));
            }
            #je persiste mes entités
            $this->em->persist($facture);
            $this->em->persist($historiquePaiement);

            #je demande à entity manager d'exécuter la requête
            $this->em->flush();

            $this->addFlash('info', 'Avance ajoutée avec succès !');

            return $this->redirectToRoute('liste_facture', ['m' => 1]);

        }

        return $this->render('facture/ajoutAvance.html.twig', [
            'licence' => 1,
            'facture' => $facture,
            'ajoutAvanceForm' => $form->createView(),
        ]);
    }
}
