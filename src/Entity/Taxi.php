<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaxiRepository")
 */
class Taxi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxiEtat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxiSysteme;

    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $emeteur;

    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private $recepteur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaxiEtat(): ?int
    {
        return $this->taxiEtat;
    }

    public function setTaxiEtat(?int $taxiEtat): self
    {
        $this->taxiEtat = $taxiEtat;

        return $this;
    }

    public function getTaxiSysteme(): ?int
    {
        return $this->taxiSysteme;
    }

    public function setTaxiSysteme(?int $taxiSysteme): self
    {
        $this->taxiSysteme = $taxiSysteme;

        return $this;
    }

    public function getEmeteur(): ?string
    {
        return $this->emeteur;
    }

    public function setEmeteur(?string $emeteur): self
    {
        $this->emeteur = $emeteur;

        return $this;
    }

    public function getRecepteur(): ?string
    {
        return $this->recepteur;
    }

    public function setRecepteur(?string $recepteur): self
    {
        $this->recepteur = $recepteur;

        return $this;
    }
}
