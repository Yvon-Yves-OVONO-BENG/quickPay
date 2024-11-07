<?php

namespace App\Controller\Produit;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit')]
class DetailsProduitController extends AbstractController
{
    public function __construct(
        protected ProduitRepository $produitRepository)
    {}

    #[Route('/details-produit/{slug}', name: 'details_produit')]
    public function detailsProduit(int $slug): Response
    {
        $produit = $this->produitRepository->findOneBySlug([
            'slug' => $slug
        ]);

        return $this->render('produit/detailsProduit.html.twig', [
            'licence' => 1,
            'produit' => $produit,
        ]);
    }
}
