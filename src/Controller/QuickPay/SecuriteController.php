<?php

namespace App\Controller\QuickPay;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecuriteController extends AbstractController
{
    #[Route('/securite', name: 'securite')]
    public function securite(): Response
    {
        return $this->render('quick_pay/securite.html.twig', [
        ]);
    }
}
