<?php

namespace App\Controller\QuickPay;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TermesEtConditionsController extends AbstractController
{
    #[Route('/termesEtConditions', name: 'termesEtConditions')]
    public function termesEtConditions(): Response
    {
        return $this->render('quick_pay/termesEtConditions.html.twig', [
        ]);
    }
}
