<?php

namespace App\Controller\QuickPay;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuickPayController extends AbstractController
{
    #[Route('/quickpay', name: 'quick_pay')]
    public function quickpay(): Response
    {
        return $this->render('quick_pay/quickpay.html.twig', [
        ]);
    }
}
