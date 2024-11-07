<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    public function __construct(
        protected RequestStack $request,
        protected ProduitRepository $produitRepository, 
        )
    {
    }

    public function ajout(string $slug, int $qte)
    {
        $maSession = $this->request->getSession();
        // 1. Retouver le panier dans la session(sous forme de tableau)
        // 2. S'il n'existe pas encore, alors prendre un tableau vide
        // $panier = $this->request->getSession()->get('panier', []);
        
        $panier = $maSession->get('panier', []);
        
        // 3. Voir si le produit ($slug) existe déjà dans le tableau
        // 4. Si c'est le cas, simplement augmenter la quantité
        // 5. Sinon, ajouter le produit avec la quantité
        
        if ($qte) 
        {
            if ($qte == 0) 
            {
                //je supprime le produit $slug de mon panier
                unset($panier[$slug]);

                ///je met mon panier à jour
                $maSession->set('panier', $panier);
                // $this->request->getSession()->set('panier', $panier);
            } 
            else 
            {
                $panier[$slug] = $qte;
            }
        } 
        elseif (array_key_exists($slug, $panier)) 
        {
            $panier[$slug]++;
        } 
        else 
        {
            $panier[$slug] = 1;
        }

        // 6. Enregistrer le tableau mis à jour dans la session
        $maSession->set('panier', $panier);
        
    }

    public function metPanierAjour(array $panier)
    {
        $maSession = $this->request->getSession();
        // $this->request->getSession()->set('panier', $panier);
        $maSession->set('panier', $panier);
    }

    public function viderPanier()
    {
        $this->metPanierAjour([]);
    }

    public function supprimer(string $slug)
    {
        $maSession = $this->request->getSession();

        // je récupère mon panier. sinon je prend un panier vide
        $panier = $maSession->get('panier', []);

        //je supprime le produit $slug de mon panier
        unset($panier[$slug]);

        ///je met mon panier à jour
        $maSession->set('panier', $panier);
    }

    public function decrementer(string $slug)
    {
        $maSession = $this->request->getSession();

        $panier = $maSession->get('panier', []);

        if (!array_key_exists($slug, $panier)) 
        {
            return;
        }

        ////si le produit est à 1 alors il faut simplement le supprimer
        if ($panier[$slug] === 1) 
        {
            $this->supprimer($slug);
            return;
        }

        /////sinon la produit est plus de 1, il faut le décrementer
        $panier[$slug]--;

        $maSession->set('panier', $panier);
    }

    public function getTotal(): int
    {
        $maSession = $this->request->getSession();
        $total = 0;

        foreach ($maSession->get('panier', [])  as $slug => $qte) 
        {
            $produit = $this->produitRepository->findOneBySlug([
                'slug' => $slug
            ]);

            if (!$produit) 
            {
                continue;

            }

            $total += ($produit->getPrixVente() * $qte);
        }

        return $total;
    }

    /**
     * @return DetailsPanierProduit[]
     */
    public function getDetailsPanierProduits(): array
    {
        $maSession = $this->request->getSession();
        $detailsPanier = [];

        foreach ($maSession->get('panier', []) as $slug => $qte) 
        {
            $produit = $this->produitRepository->findOneBySlug([
                'slug' => $slug
            ]);

            if (!$produit) 
            {
                continue;
            }

            $detailsPanier[] = new PanierProduitService($produit, $qte);
        }

        return $detailsPanier;
    }
}
