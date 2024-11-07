<?php

namespace App\Entity;

use App\Repository\LigneDeFactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneDeFactureRepository::class)]
class LigneDeFacture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneDeFactures')]
    private ?Facture $facture = null;

    #[ORM\ManyToOne(inversedBy: 'ligneDeFactures')]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $prixQuantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): static
    {
        $this->facture = $facture;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixQuantite(): ?int
    {
        return $this->prixQuantite;
    }

    public function setPrixQuantite(int $prixQuantite): static
    {
        $this->prixQuantite = $prixQuantite;

        return $this;
    }
}
