<?php

namespace App\Controller\Patient;

use App\Repository\FactureRepository;
use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER", message="Accès refusé. Espace reservé uniquement aux abonnés")
 *
 */
#[Route('patient')]

class AfficherPriseEnChargeController extends AbstractController
{
    public function __construct(
        protected PatientRepository $patientRepository,
        protected FactureRepository $factureRepository
    )
    {}

    #[Route('/afficher-prise-en-charge/{code}', name: 'afficher_prise_en_charge')]
    public function afficherPatient(Request $request, $code): Response
    {
        #je teste si le témoin n'est pas vide pour savoir s'il vient de la suppression
        
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('suppression', null);
        
        
        
        #je récupère le patient dont je veix afficher les prises en charge
        $patient = $this->patientRepository->findOneByCode([
            'code' => $code
        ]);
        
        #je récupère toutes les patients
        $factures = $this->factureRepository->findBy([
            'patient' => $patient,
            'annulee' => 0
        ]);
        
        #j'envoie mon tableau des categories à mon rendu twig pour affichage
        return $this->render('patient/afficherPriseEnCharge.html.twig', [
            'licence' => 1,
            'patient' => $patient,
            'factures' => $factures,
        ]);
    }
}
