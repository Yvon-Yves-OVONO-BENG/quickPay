<?php

namespace App\Entity;

use App\Repository\FournisseurProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurProduitRepository::class)]
class FournisseurProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fournisseurProduits')]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(inversedBy: 'fournisseurProduits')]
    private ?Produit $produit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCommandeAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateLivraisonAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

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

    public function getDateCommandeAt(): ?\DateTimeInterface
    {
        return $this->dateCommandeAt;
    }

    public function setDateCommandeAt(?\DateTimeInterface $dateCommandeAt): static
    {
        $this->dateCommandeAt = $dateCommandeAt;

        return $this;
    }

    public function getDateLivraisonAt(): ?\DateTimeInterface
    {
        return $this->dateLivraisonAt;
    }

    public function setDateLivraisonAt(?\DateTimeInterface $dateLivraisonAt): static
    {
        $this->dateLivraisonAt = $dateLivraisonAt;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
