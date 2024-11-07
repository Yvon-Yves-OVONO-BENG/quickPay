<?php

namespace App\Service;

use App\Entity\Produit;

class PanierProduitService
{
    
    public function __construct(public Produit $produit, public int $qte)
    {}

    public function getTotal(): int
    {
        return $this->produit->getPrixVente() * $this->qte;
    }
}