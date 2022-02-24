<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $reference;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'text')]
    private $adrLivraison;

    #[ORM\Column(type: 'string', length: 255)]
    private $tsociete;

    #[ORM\Column(type: 'float')]
    private $tprix;

    #[ORM\Column(type: 'text', nullable: true)]
    private $adrFacturation;

    #[ORM\Column(type: 'boolean')]
    private $isFinalized;

    #[ORM\OneToMany(mappedBy: 'Commande', targetEntity: CommandeLigne::class)]
    private $commandeLignes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stripeId;

    public function __construct()
    {
        $this->commandeLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdrLivraison(): ?string
    {
        return $this->adrLivraison;
    }

    public function setAdrLivraison(string $adrLivraison): self
    {
        $this->adrLivraison = $adrLivraison;

        return $this;
    }

    public function getTsociete(): ?string
    {
        return $this->tsociete;
    }

    public function setTsociete(string $tsociete): self
    {
        $this->tsociete = $tsociete;

        return $this;
    }

    public function getTprix(): ?float
    {
        return $this->tprix;
    }

    public function setTprix(float $tprix): self
    {
        $this->tprix = $tprix;

        return $this;
    }

    public function getAdrFacturation(): ?string
    {
        return $this->adrFacturation;
    }

    public function setAdrFacturation(?string $adrFacturation): self
    {
        $this->adrFacturation = $adrFacturation;

        return $this;
    }

    public function getIsFinalized(): ?bool
    {
        return $this->isFinalized;
    }

    public function setIsFinalized(bool $isFinalized): self
    {
        $this->isFinalized = $isFinalized;

        return $this;
    }

    /**
     * @return Collection|CommandeLigne[]
     */
    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes[] = $commandeLigne;
            $commandeLigne->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): self
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            // set the owning side to null (unless already changed)
            if ($commandeLigne->getCommande() === $this) {
                $commandeLigne->setCommande(null);
            }
        }

        return $this;
    }

    public function getStripeId(): ?string
    {
        return $this->stripeId;
    }

    public function setStripeId(?string $stripeId): self
    {
        $this->stripeId = $stripeId;

        return $this;
    }
}
