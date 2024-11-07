<?php

namespace App\Entity;

use App\Repository\PrescripteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrescripteurRepository::class)]
class Prescripteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prescripteur = null;

    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'prescripteur')]
    private Collection $factures;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrescripteur(): ?string
    {
        return $this->prescripteur;
    }

    public function setPrescripteur(string $prescripteur): static
    {
        $this->prescripteur = $prescripteur;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setPrescripteur($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getPrescripteur() === $this) {
                $facture->setPrescripteur(null);
            }
        }

        return $this;
    }
}
