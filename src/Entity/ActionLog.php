<?php

namespace App\Entity;

use App\Repository\ActionLogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionLogRepository::class)]
class ActionLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $actionLog = null;

    #[ORM\OneToMany(targetEntity: AuditLog::class, mappedBy: 'actionLog')]
    private Collection $auditLogs;

    public function __construct()
    {
        $this->auditLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionLog(): ?string
    {
        return $this->actionLog;
    }

    public function setActionLog(string $actionLog): static
    {
        $this->actionLog = $actionLog;

        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getauditLogs(): Collection
    {
        return $this->auditLogs;
    }

    public function addAuditLogs(AuditLog $auditLog): static
    {
        if (!$this->auditLogs->contains($auditLog)) {
            $this->auditLogs->add($auditLog);
            $auditLog->setActionLog($this);
        }

        return $this;
    }

    public function removeLog(AuditLog $auditLog): static
    {
        if ($this->auditLogs->removeElement($auditLog)) {
            // set the owning side to null (unless already changed)
            if ($auditLog->getActionLog() === $this) {
                $auditLog->setActionLog(null);
            }
        }

        return $this;
    }
}
