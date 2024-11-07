<?php

namespace App\Entity;

use App\Repository\LigneDeKitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneDeKitRepository::class)]
class LigneDeKit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneDeKits')]
    private ?Produit $produit = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantite = null;

    #[ORM\Column(nullable: true)]
    private ?int $prix = null;

    #[ORM\Column(nullable: true)]
    private ?int $total = null;

    #[ORM\ManyToOne(inversedBy: 'produitLigneDeKits')]
    private ?Produit $produitKit = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setQuantite(?int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getProduitKit(): ?Produit
    {
        return $this->produitKit;
    }

    public function setProduitKit(?Produit $produitKit): static
    {
        $this->produitKit = $produitKit;

        return $this;
    }
}
