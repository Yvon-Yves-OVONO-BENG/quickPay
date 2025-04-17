<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expediteur')]
    private ?User $expediteur = null;

    #[ORM\ManyToOne(inversedBy: 'destinataire')]
    private ?User $destinataire = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $messageCrypte = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $envoyeLeAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aesIv = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Cryptographie $cryptographie = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\Column]
    private ?bool $supprimerDefinitivement = null;

    #[ORM\ManyToOne(inversedBy: 'supprimePar')]
    private ?User $supprimePar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supprimeLeAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $spam = null;

    #[ORM\Column]
    private ?bool $lu = null;

    #[ORM\Column]
    private ?bool $important = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpediteur(): ?User
    {
        return $this->expediteur;
    }

    public function setExpediteur(?User $expediteur): static
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?User
    {
        return $this->destinataire;
    }

    public function setDestinataire(?User $destinataire): static
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getMessageCrypte(): ?string
    {
        return $this->messageCrypte;
    }

    public function setMessageCrypte(string $messageCrypte): static
    {
        $this->messageCrypte = $messageCrypte;

        return $this;
    }

    public function getEnvoyeLeAt(): ?\DateTimeInterface
    {
        return $this->envoyeLeAt;
    }

    public function setEnvoyeLeAt(\DateTimeInterface $envoyeLeAt): static
    {
        $this->envoyeLeAt = $envoyeLeAt;

        return $this;
    }

    public function getAesIv(): ?string
    {
        return $this->aesIv;
    }

    public function setAesIv(?string $aesIv): static
    {
        $this->aesIv = $aesIv;

        return $this;
    }

    public function getCryptographie(): ?Cryptographie
    {
        return $this->cryptographie;
    }

    public function setCryptographie(?Cryptographie $cryptographie): static
    {
        $this->cryptographie = $cryptographie;

        return $this;
    }

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): static
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function isSupprimerDefinitivement(): ?bool
    {
        return $this->supprimerDefinitivement;
    }

    public function setSupprimerDefinitivement(bool $supprimerDefinitivement): static
    {
        $this->supprimerDefinitivement = $supprimerDefinitivement;

        return $this;
    }

    public function getSupprimePar(): ?User
    {
        return $this->supprimePar;
    }

    public function setSupprimePar(?User $supprimePar): static
    {
        $this->supprimePar = $supprimePar;

        return $this;
    }

    public function getSupprimeLeAt(): ?\DateTimeInterface
    {
        return $this->supprimeLeAt;
    }

    public function setSupprimeLeAt(?\DateTimeInterface $supprimeLeAt): static
    {
        $this->supprimeLeAt = $supprimeLeAt;

        return $this;
    }

    public function isSpam(): ?bool
    {
        return $this->spam;
    }

    public function setSpam(?bool $spam): static
    {
        $this->spam = $spam;

        return $this;
    }

    public function isLu(): ?bool
    {
        return $this->lu;
    }

    public function setLu(bool $lu): static
    {
        $this->lu = $lu;

        return $this;
    }

    public function isImportant(): ?bool
    {
        return $this->important;
    }

    public function setImportant(bool $important): static
    {
        $this->important = $important;

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
