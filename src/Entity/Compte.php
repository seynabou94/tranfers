<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte")
     */
    private $depots;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\JoinColumn(nullable=true)
     */
    private $date_creation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajaction", mappedBy="copmte")
     */
    private $trajactions;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->trajactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

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

    public function getPartenire(): ?Partenaire
    {
        return $this->partenire;
    }

    public function setPartenire(?Partenaire $partenire): self
    {
        $this->partenire = $partenire;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @return Collection|Trajaction[]
     */
    public function getTrajactions(): Collection
    {
        return $this->trajactions;
    }

    public function addTrajaction(Trajaction $trajaction): self
    {
        if (!$this->trajactions->contains($trajaction)) {
            $this->trajactions[] = $trajaction;
            $trajaction->setCopmte($this);
        }

        return $this;
    }

    public function removeTrajaction(Trajaction $trajaction): self
    {
        if ($this->trajactions->contains($trajaction)) {
            $this->trajactions->removeElement($trajaction);
            // set the owning side to null (unless already changed)
            if ($trajaction->getCopmte() === $this) {
                $trajaction->setCopmte(null);
            }
        }

        return $this;
    }
}
