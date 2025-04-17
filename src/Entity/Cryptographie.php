<?php

namespace App\Entity;

use App\Repository\CryptographieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CryptographieRepository::class)]
class Cryptographie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cryptographie = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'cryptographie')]
    private Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCryptographie(): ?string
    {
        return $this->cryptographie;
    }

    public function setCryptographie(string $cryptographie): static
    {
        $this->cryptographie = $cryptographie;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setCryptographie($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getCryptographie() === $this) {
                $message->setCryptographie(null);
            }
        }

        return $this;
    }
}
