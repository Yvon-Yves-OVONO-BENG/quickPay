<?php

namespace App\Controller\Message;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LireMessageAESController extends AbstractController
{
    #[Route('/lire/message', name: 'lire_message_aes')]
    public function index(): Response
    {
        return $this->render('lire_message/index.html.twig', [
            'controller_name' => 'LireMessageController',
        ]);
    }
}
