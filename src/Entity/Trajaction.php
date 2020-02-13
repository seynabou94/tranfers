<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TrajactionRepository")
 */
class Trajaction
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
    private $code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $frais;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typePieceEmetteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numeroPieceEmetteur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnvoi;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telephoneEmetteur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commissionEmetteur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetait;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typePieceRecepteur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telephoRecepteur;

    /**
     * @ORM\Column(type="integer" ,nullable=true
     * )
     */
    private $numeroPieceRecepteur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commissionRecepteur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $commissionSysteme;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $taxiEtat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenoR;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomR;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_piece_envoi;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trajactions")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="trajactions")
     */
    private $copmte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontat(): ?int
    {
        return $this->montat;
    }

    public function setMontat(?int $montat): self
    {
        $this->montat = $montat;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(?int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }


    public function getTypePieceEmetteur(): ?string
    {
        return $this->typePieceEmetteur;
    }

    public function setTypePieceEmetteur(?string $typePieceEmetteur): self
    {
        $this->typePieceEmetteur = $typePieceEmetteur;

        return $this;
    }

    public function getNumeroPieceEmetteur(): ?int
    {
        return $this->numeroPieceEmetteur;
    }

    public function setNumeroPieceEmetteur(?int $numeroPieceEmetteur): self
    {
        $this->numeroPieceEmetteur = $numeroPieceEmetteur;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(?\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getTelephoneEmetteur(): ?int
    {
        return $this->telephoneEmetteur;
    }

    public function setTelephoneEmetteur(?int $telephoneEmetteur): self
    {
        $this->telephoneEmetteur = $telephoneEmetteur;

        return $this;
    }

    public function getCommissionEmetteur(): ?float
    {
        return $this->commissionEmetteur;
    }

    public function setCommissionEmetteur(?float $commissionEmetteur): self
    {
        $this->commissionEmetteur = $commissionEmetteur;

        return $this;
    }

    public function getDateRetait(): ?\DateTimeInterface
    {
        return $this->dateRetait;
    }

    public function setDateRetait(?\DateTimeInterface $dateRetait): self
    {
        $this->dateRetait = $dateRetait;

        return $this;
    }

    

    public function getTypePieceRecepteur(): ?string
    {
        return $this->typePieceRecepteur;
    }

    public function setTypePieceRecepteur(?string $typePieceRecepteur): self
    {
        $this->typePieceRecepteur = $typePieceRecepteur;

        return $this;
    }

    public function getTelephoRecepteur(): ?int
    {
        return $this->telephoRecepteur;
    }

    public function setTelephoRecepteur(?int $telephoRecepteur): self
    {
        $this->telephoRecepteur = $telephoRecepteur;

        return $this;
    }

    public function getNumeroPieceRecepteur(): ?int
    {
        return $this->numeroPieceRecepteur;
    }

    public function setNumeroPieceRecepteur(int $numeroPieceRecepteur): self
    {
        $this->numeroPieceRecepteur = $numeroPieceRecepteur;

        return $this;
    }

    public function getCommissionRecepteur(): ?float
    {
        return $this->commissionRecepteur;
    }

    public function setCommissionRecepteur(?float $commissionRecepteur): self
    {
        $this->commissionRecepteur = $commissionRecepteur;

        return $this;
    }

    public function getCommissionSysteme(): ?float
    {
        return $this->commissionSysteme;
    }

    public function setCommissionSysteme(?float $commissionSysteme): self
    {
        $this->commissionSysteme = $commissionSysteme;

        return $this;
    }

    public function getTaxiEtat(): ?float
    {
        return $this->taxiEtat;
    }

    public function setTaxiEtat(?float $taxiEtat): self
    {
        $this->taxiEtat = $taxiEtat;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrenomE(): ?string
    {
        return $this->prenomE;
    }

    public function setPrenomE(?string $prenomE): self
    {
        $this->prenomE = $prenomE;

        return $this;
    }

    public function getNomE(): ?string
    {
        return $this->nomE;
    }

    public function setNomE(?string $nomE): self
    {
        $this->nomE = $nomE;

        return $this;
    }

    public function getPrenoR(): ?string
    {
        return $this->prenoR;
    }

    public function setPrenoR(?string $prenoR): self
    {
        $this->prenoR = $prenoR;

        return $this;
    }

    public function getNomR(): ?string
    {
        return $this->nomR;
    }

    public function setNomR(?string $nomR): self
    {
        $this->nomR = $nomR;

        return $this;
    }

    public function getTypePieceEnvoi(): ?string
    {
        return $this->type_piece_envoi;
    }

    public function setTypePieceEnvoi(?string $type_piece_envoi): self
    {
        $this->type_piece_envoi = $type_piece_envoi;

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

    public function getCopmte(): ?Compte
    {
        return $this->copmte;
    }

    public function setCopmte(?Compte $copmte): self
    {
        $this->copmte = $copmte;

        return $this;
    }
}
