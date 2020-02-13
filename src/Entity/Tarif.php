<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $borne_sup;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $borne_inf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getBorneSup(): ?int
    {
        return $this->borne_sup;
    }

    public function setBorneSup(?int $borne_sup): self
    {
        $this->borne_sup = $borne_sup;

        return $this;
    }

    public function getBorneInf(): ?int
    {
        return $this->borne_inf;
    }

    public function setBorneInf(?int $borne_inf): self
    {
        $this->borne_inf = $borne_inf;

        return $this;
    }
}
