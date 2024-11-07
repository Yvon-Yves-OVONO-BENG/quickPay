<?php

namespace App\Entity;

use App\Repository\LicenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LicenceRepository::class)]
class Licence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreJours = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExpirationAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreJours(): ?int
    {
        return $this->nombreJours;
    }

    public function setNombreJours(?int $nombreJours): static
    {
        $this->nombreJours = $nombreJours;

        return $this;
    }

    public function getDateExpirationAt(): ?\DateTimeInterface
    {
        return $this->dateExpirationAt;
    }

    public function setDateExpirationAt(?\DateTimeInterface $dateExpirationAt): static
    {
        $this->dateExpirationAt = $dateExpirationAt;

        return $this;
    }
}
