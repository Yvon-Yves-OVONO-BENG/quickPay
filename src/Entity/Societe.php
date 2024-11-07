<?php

namespace App\Entity;

use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocieteRepository::class)]
class Societe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $societe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(targetEntity: Patient::class, mappedBy: 'societe')]
    private Collection $patients;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(?string $societe): static
    {
        $this->societe = $societe;

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

    /**
     * @return Collection<int, Patient>
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patients->contains($patient)) {
            $this->patients->add($patient);
            $patient->setSociete($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getSociete() === $this) {
                $patient->setSociete(null);
            }
        }

        return $this;
    }
}
