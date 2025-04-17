<?php

namespace App\Controller\FactureBillet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class FactureBilletController extends AbstractController
{
    #[Route('/facture-billet', name: 'facture_billet')]
    public function factureBillet(): Response
    {
        return $this->render('facture_billet/facture_billet.html.twig', [
            'controller_name' => 'FactureBilletController',
        ]);
    }
}
