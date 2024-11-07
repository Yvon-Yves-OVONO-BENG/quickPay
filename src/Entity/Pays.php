<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\OneToMany(targetEntity: Patient::class, mappedBy: 'pays')]
    private Collection $patients;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

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
            $patient->setPays($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getPays() === $this) {
                $patient->setPays(null);
            }
        }

        return $this;
    }
}
