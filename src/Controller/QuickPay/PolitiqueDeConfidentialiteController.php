<?php

namespace App\Controller\QuickPay;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PolitiqueDeConfidentialiteController extends AbstractController
{
    #[Route('/politiqueDeConfidentialite', name: 'politiqueDeConfidentialite')]
    public function politiqueDeConfidentialite(): Response
    {
        return $this->render('quick_pay/politiqueDeConfidentialite.html.twig', [
        ]);
    }
}
