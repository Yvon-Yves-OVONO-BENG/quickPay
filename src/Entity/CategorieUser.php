<?php

namespace App\Entity;

use App\Repository\CategorieUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieUserRepository::class)]
class CategorieUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorieUser = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'categorieUser')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieUser(): ?string
    {
        return $this->categorieUser;
    }

    public function setCategorieUser(string $categorieUser): static
    {
        $this->categorieUser = $categorieUser;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCategorieUser($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCategorieUser() === $this) {
                $user->setCategorieUser(null);
            }
        }

        return $this;
    }
}
