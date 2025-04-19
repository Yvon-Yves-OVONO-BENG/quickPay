<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Un compte existant utilise déjà cette adresse email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[Assert\IdenticalTo(propertyPath:'password', message:'Les mots de passe doivent être identiques')]
    private $confirmPassword;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\OneToMany(targetEntity: ReponseQuestion::class, mappedBy: 'user')]
    private Collection $reponseQuestions;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Genre $genre = null;

    #[ORM\OneToMany(targetEntity: AuditLog::class, mappedBy: 'user')]
    private Collection $auditLogs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cleRsaPublique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cleRsaPrivee = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'expediteur')]
    private Collection $expediteur;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'destinataire')]
    private Collection $destinataire;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'supprimePar')]
    private Collection $supprimePar;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'expediteur')]
    private Collection $expediteurTransactions;

    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'destinataire')]
    private Collection $destinataireTransaction;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?PorteMonnaie $porteMonnaie = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?CodeQr $codeQr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numCni = null;

    #[ORM\OneToMany(targetEntity: DemandeModificationMotDePasse::class, mappedBy: 'user')]
    private Collection $demandeModificationMotDePasses;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?TypeUser $typeUser = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?CategorieUser $categorieUser = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Pays $pays = null;

    public function __construct()
    {
        $this->reponseQuestions = new ArrayCollection();
        $this->auditLogs = new ArrayCollection();
        $this->expediteur = new ArrayCollection();
        $this->destinataire = new ArrayCollection();
        $this->supprimePar = new ArrayCollection();
        $this->expediteurTransactions = new ArrayCollection();
        $this->destinataireTransaction = new ArrayCollection();
        $this->demandeModificationMotDePasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getConfirmPassword(): string
    {
        return (string) $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

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
    
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function serialize()
    {
        $this->photo = base64_encode($this->photo);
    }

    public function unserialize($serialized)
    {
        $this->photo = base64_decode($this->photo);

    }

    /**
     * @return Collection<int, ReponseQuestion>
     */
    public function getReponseQuestions(): Collection
    {
        return $this->reponseQuestions;
    }

    public function addReponseQuestion(ReponseQuestion $reponseQuestion): static
    {
        if (!$this->reponseQuestions->contains($reponseQuestion)) {
            $this->reponseQuestions->add($reponseQuestion);
            $reponseQuestion->setUser($this);
        }

        return $this;
    }

    public function removeReponseQuestion(ReponseQuestion $reponseQuestion): static
    {
        if ($this->reponseQuestions->removeElement($reponseQuestion)) {
            // set the owning side to null (unless already changed)
            if ($reponseQuestion->getUser() === $this) {
                $reponseQuestion->setUser(null);
            }
        }

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getAuditLogs(): Collection
    {
        return $this->auditLogs;
    }

    public function addAuditLog(AuditLog $auditLog): static
    {
        if (!$this->auditLogs->contains($auditLog)) {
            $this->auditLogs->add($auditLog);
            $auditLog->setUser($this);
        }

        return $this;
    }

    public function removeAuditLog(AuditLog $auditLog): static
    {
        if ($this->auditLogs->removeElement($auditLog)) {
            // set the owning side to null (unless already changed)
            if ($auditLog->getUser() === $this) {
                $auditLog->setUser(null);
            }
        }

        return $this;
    }

    public function getCleRsaPublique(): ?string
    {
        return $this->cleRsaPublique;
    }

    public function setCleRsaPublique(string $cleRsaPublique): static
    {
        $this->cleRsaPublique = $cleRsaPublique;

        return $this;
    }

    public function getCleRsaPrivee(): ?string
    {
        return $this->cleRsaPrivee;
    }

    public function setCleRsaPrivee(string $cleRsaPrivee): static
    {
        $this->cleRsaPrivee = $cleRsaPrivee;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getExpediteur(): Collection
    {
        return $this->expediteur;
    }

    public function addExpediteur(Message $expediteur): static
    {
        if (!$this->expediteur->contains($expediteur)) {
            $this->expediteur->add($expediteur);
            $expediteur->setExpediteur($this);
        }

        return $this;
    }

    public function removeExpediteur(Message $expediteur): static
    {
        if ($this->expediteur->removeElement($expediteur)) {
            // set the owning side to null (unless already changed)
            if ($expediteur->getExpediteur() === $this) {
                $expediteur->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getDestinataire(): Collection
    {
        return $this->destinataire;
    }

    public function addDestinataire(Message $destinataire): static
    {
        if (!$this->destinataire->contains($destinataire)) {
            $this->destinataire->add($destinataire);
            $destinataire->setDestinataire($this);
        }

        return $this;
    }

    public function removeDestinataire(Message $destinataire): static
    {
        if ($this->destinataire->removeElement($destinataire)) {
            // set the owning side to null (unless already changed)
            if ($destinataire->getDestinataire() === $this) {
                $destinataire->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getSupprimePar(): Collection
    {
        return $this->supprimePar;
    }

    public function addSupprimePar(Message $supprimePar): static
    {
        if (!$this->supprimePar->contains($supprimePar)) {
            $this->supprimePar->add($supprimePar);
            $supprimePar->setSupprimePar($this);
        }

        return $this;
    }

    public function removeSupprimePar(Message $supprimePar): static
    {
        if ($this->supprimePar->removeElement($supprimePar)) {
            // set the owning side to null (unless already changed)
            if ($supprimePar->getSupprimePar() === $this) {
                $supprimePar->setSupprimePar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getExpediteurTransactions(): Collection
    {
        return $this->expediteurTransactions;
    }

    public function addExpediteurTransactions(Transaction $expediteurTransactions): static
    {
        if (!$this->expediteurTransactions->contains($expediteurTransactions)) {
            $this->expediteurTransactions->add($expediteurTransactions);
            $expediteurTransactions->setExpediteur($this);
        }

        return $this;
    }

    public function removeExpediteurTransaction(Transaction $expediteurTransactions): static
    {
        if ($this->expediteurTransactions->removeElement($expediteurTransactions)) {
            // set the owning side to null (unless already changed)
            if ($expediteurTransactions->getExpediteur() === $this) {
                $expediteurTransactions->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getDestinataireTransaction(): Collection
    {
        return $this->destinataireTransaction;
    }

    public function addDestinataireTransaction(Transaction $destinataireTransaction): static
    {
        if (!$this->destinataireTransaction->contains($destinataireTransaction)) {
            $this->destinataireTransaction->add($destinataireTransaction);
            $destinataireTransaction->setDestinataire($this);
        }

        return $this;
    }

    public function removeDestinataireTransaction(Transaction $destinataireTransaction): static
    {
        if ($this->destinataireTransaction->removeElement($destinataireTransaction)) {
            // set the owning side to null (unless already changed)
            if ($destinataireTransaction->getDestinataire() === $this) {
                $destinataireTransaction->setDestinataire(null);
            }
        }

        return $this;
    }

    public function getPorteMonnaie(): ?PorteMonnaie
    {
        return $this->porteMonnaie;
    }

    public function setPorteMonnaie(?PorteMonnaie $porteMonnaie): static
    {
        $this->porteMonnaie = $porteMonnaie;

        return $this;
    }

    public function getCodeQr(): ?CodeQr
    {
        return $this->codeQr;
    }

    public function setCodeQr(?CodeQr $codeQr): static
    {
        $this->codeQr = $codeQr;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getNumCni(): ?string
    {
        return $this->numCni;
    }

    public function setNumCni(?string $numCni): static
    {
        $this->numCni = $numCni;

        return $this;
    }

    /**
     * @return Collection<int, DemandeModificationMotDePasse>
     */
    public function getDemandeModificationMotDePasses(): Collection
    {
        return $this->demandeModificationMotDePasses;
    }

    public function addDemandeModificationMotDePass(DemandeModificationMotDePasse $demandeModificationMotDePass): static
    {
        if (!$this->demandeModificationMotDePasses->contains($demandeModificationMotDePass)) {
            $this->demandeModificationMotDePasses->add($demandeModificationMotDePass);
            $demandeModificationMotDePass->setUser($this);
        }

        return $this;
    }

    public function removeDemandeModificationMotDePass(DemandeModificationMotDePasse $demandeModificationMotDePass): static
    {
        if ($this->demandeModificationMotDePasses->removeElement($demandeModificationMotDePass)) {
            // set the owning side to null (unless already changed)
            if ($demandeModificationMotDePass->getUser() === $this) {
                $demandeModificationMotDePass->setUser(null);
            }
        }

        return $this;
    }

    public function getTypeUser(): ?TypeUser
    {
        return $this->typeUser;
    }

    public function setTypeUser(?TypeUser $typeUser): static
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    public function getCategorieUser(): ?CategorieUser
    {
        return $this->categorieUser;
    }

    public function setCategorieUser(?CategorieUser $categorieUser): static
    {
        $this->categorieUser = $categorieUser;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

}
