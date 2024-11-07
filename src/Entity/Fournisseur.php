<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fournisseur = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: FournisseurProduit::class, mappedBy: 'fournisseur')]
    private Collection $fournisseurProduits;

    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'fournisseur')]
    private Collection $commandes;

    public function __construct()
    {
        $this->fournisseurProduits = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(string $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

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

    /**
     * @return Collection<int, FournisseurProduit>
     */
    public function getFournisseurProduits(): Collection
    {
        return $this->fournisseurProduits;
    }

    public function addFournisseurProduit(FournisseurProduit $fournisseurProduit): static
    {
        if (!$this->fournisseurProduits->contains($fournisseurProduit)) {
            $this->fournisseurProduits->add($fournisseurProduit);
            $fournisseurProduit->setFournisseur($this);
        }

        return $this;
    }

    public function removeFournisseurProduit(FournisseurProduit $fournisseurProduit): static
    {
        if ($this->fournisseurProduits->removeElement($fournisseurProduit)) {
            // set the owning side to null (unless already changed)
            if ($fournisseurProduit->getFournisseur() === $this) {
                $fournisseurProduit->setFournisseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setFournisseur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getFournisseur() === $this) {
                $commande->setFournisseur(null);
            }
        }

        return $this;
    }
}
