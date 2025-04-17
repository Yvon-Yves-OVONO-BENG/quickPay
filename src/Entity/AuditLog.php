<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class AuditLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logs')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateActionAt = null;

    #[ORM\ManyToOne(inversedBy: 'logs')]
    private ?ActionLog $actionLog = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDateActionAt(): ?\DateTimeInterface
    {
        return $this->dateActionAt;
    }

    public function setDateActionAt(\DateTimeInterface $dateActionAt): static
    {
        $this->dateActionAt = $dateActionAt;

        return $this;
    }

    public function getActionLog(): ?ActionLog
    {
        return $this->actionLog;
    }

    public function setActionLog(?ActionLog $actionLog): static
    {
        $this->actionLog = $actionLog;

        return $this;
    }
}
