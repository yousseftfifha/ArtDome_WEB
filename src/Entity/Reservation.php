<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="_idx", columns={"idclient"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="idclient", type="integer", nullable=false)
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer", nullable=false)
     */
    private $matricule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_retour", type="string", length=45, nullable=true)
     */
    private $dateRetour;

    /**
     * @var int
     *
     * @ORM\Column(name="Cautionnement", type="integer", nullable=false)
     */
    private $cautionnement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prix_total", type="string", length=45, nullable=true)
     */
    private $prixTotal;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function setIdclient(int $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateRetour(): ?string
    {
        return $this->dateRetour;
    }

    public function setDateRetour(?string $dateRetour): self
    {
        $this->dateRetour = $dateRetour;

        return $this;
    }

    public function getCautionnement(): ?int
    {
        return $this->cautionnement;
    }

    public function setCautionnement(int $cautionnement): self
    {
        $this->cautionnement = $cautionnement;

        return $this;
    }

    public function getPrixTotal(): ?string
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(?string $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }


}
