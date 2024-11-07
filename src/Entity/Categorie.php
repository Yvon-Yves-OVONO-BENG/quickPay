<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: SousCategorie::class, mappedBy: 'categorie')]
    private Collection $sousCategories;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

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
     * @return Collection<int, SousCategorie>
     */
    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategory(SousCategorie $sousCategory): static
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories->add($sousCategory);
            $sousCategory->setCategorie($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategorie $sousCategory): static
    {
        if ($this->sousCategories->removeElement($sousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCategorie() === $this) {
                $sousCategory->setCategorie(null);
            }
        }

        return $this;
    }
}
