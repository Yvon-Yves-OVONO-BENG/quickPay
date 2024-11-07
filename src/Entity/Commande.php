<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEntreeAt = null;

    #[ORM\OneToMany(targetEntity: LigneDeCommande::class, mappedBy: 'commande', cascade: ['persist', 'remove'])]
    private Collection $ligneDeCommandes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?bool $livre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateLivraisonAt = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Fournisseur $fournisseur = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $secretaire = null;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateEntreeAt(): ?\DateTimeInterface
    {
        return $this->dateEntreeAt;
    }

    public function setDateEntreeAt(?\DateTimeInterface $dateEntreeAt): static
    {
        $this->dateEntreeAt = $dateEntreeAt;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): static
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes->add($ligneDeCommande);
            $ligneDeCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): static
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getCommande() === $this) {
                $ligneDeCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isLivre(): ?bool
    {
        return $this->livre;
    }

    public function setLivre(?bool $livre): static
    {
        $this->livre = $livre;

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

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getSecretaire(): ?User
    {
        return $this->secretaire;
    }

    public function setSecretaire(?User $secretaire): static
    {
        $this->secretaire = $secretaire;

        return $this;
    }
}
