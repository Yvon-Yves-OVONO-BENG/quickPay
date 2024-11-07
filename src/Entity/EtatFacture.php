<?php

namespace App\Entity;

use App\Repository\EtatFactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatFactureRepository::class)]
class EtatFacture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatFacture = null;

    #[ORM\OneToMany(mappedBy: 'etatFacture', targetEntity: Facture::class)]
    private Collection $commandes;

    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'etatFacture')]
    private Collection $factures;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatFacture(): ?string
    {
        return $this->etatFacture;
    }

    public function setEtatFacture(?string $etatFacture): self
    {
        $this->etatFacture = $etatFacture;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->commandes;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setEtatFacture($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getEtatFacture() === $this) {
                $facture->setEtatFacture(null);
            }
        }

        return $this;
    }

}
