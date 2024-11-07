<?php

namespace App\Entity;

use App\Repository\LigneDeCommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]
class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneDeCommandes')]
    private ?Commande $commande = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePeremptionAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixUnitaire = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixVente = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixAchat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $coef = null;

    #[ORM\ManyToOne(inversedBy: 'ligneDeCommandes')]
    private ?Produit $produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

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

    public function getDatePeremptionAt(): ?\DateTimeInterface
    {
        return $this->datePeremptionAt;
    }

    public function setDatePeremptionAt(?\DateTimeInterface $datePeremptionAt): static
    {
        $this->datePeremptionAt = $datePeremptionAt;

        return $this;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(?int $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getPrixVente(): ?int
    {
        return $this->prixVente;
    }

    public function setPrixVente(?int $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getPrixAchat(): ?int
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(?int $prixAchat): static
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getCoef(): ?string
    {
        return $this->coef;
    }

    public function setCoef(?string $coef): static
    {
        $this->coef = $coef;

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

}
