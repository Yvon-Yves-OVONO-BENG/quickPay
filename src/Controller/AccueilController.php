<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    public function __construct(
        protected RouterInterface $router,
    )
    {}

    #[Route('/', name: 'accueil')]
    public function accueil(): Response
    {
        $collection = $this->router->getRouteCollection();
        $allRoutes = $collection->all();

        return $this->render('accueil/index.html.twig', [ ]);
        

    }
}
