<?php

namespace App\Controller\Message;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViderCorbeilleController extends AbstractController
{
    #[Route('/vider/corbeille', name: 'app_vider_corbeille')]
    public function index(): Response
    {
        return $this->render('vider_corbeille/index.html.twig', [
            'controller_name' => 'ViderCorbeilleController',
        ]);
    }
}
