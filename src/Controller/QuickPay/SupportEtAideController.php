<?php

namespace App\Controller\QuickPay;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SupportEtAideController extends AbstractController
{
    #[Route('/supportEtAide', name: 'supportEtAide')]
    public function supportEtAide(): Response
    {
        return $this->render('quick_pay/supportEtAide.html.twig', [
        ]);
    }
}
