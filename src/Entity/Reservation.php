<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="idclient", columns={"idclient"}), @ORM\Index(name="matricule", columns={"matricule"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("reservations:read")

     */
    private $idReservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     * @Groups("reservations:read")

     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     * @Groups("reservations:read")
     */
    private $dateFin;



    /**
     * @var string|null
     *
     * @ORM\Column(name="date_retour", type="string", length=45, nullable=true)
     * @Groups("reservations:read")
     */
    private $dateRetour;

    /**
     * @var int
     *
     * @ORM\Column(name="Cautionnement", type="integer", nullable=false)
     * @Groups("reservations:read")
     */
    private $cautionnement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prix_total", type="string", length=45, nullable=true)
     * @Groups("reservations:read")
     */
    private $prixTotal;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idclient", referencedColumnName="ID")
     * })
     * @Groups("reservations:read")
     */
    private $idclient;

    /**
     * @var Endroit
     *
     * @ORM\ManyToOne(targetEntity="Endroit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matricule", referencedColumnName="id_endroit")
     * })
     * @Groups("reservations:read")
     */
    private $matricule;

    /**
     * @return int
     */
    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    /**
     * @param int $idReservation
     */
    public function setIdReservation(int $idReservation): void
    {
        $this->idReservation = $idReservation;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut(\DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin(\DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string|null
     */
    public function getDateRetour(): ?string
    {
        return $this->dateRetour;
    }

    /**
     * @param string|null $dateRetour
     */
    public function setDateRetour(?string $dateRetour): void
    {
        $this->dateRetour = $dateRetour;
    }

    /**
     * @return int
     */
    public function getCautionnement(): ?int
    {
        return $this->cautionnement;
    }

    /**
     * @param int $cautionnement
     */
    public function setCautionnement(int $cautionnement): void
    {
        $this->cautionnement = $cautionnement;
    }

    /**
     * @return string|null
     */
    public function getPrixTotal(): ?string
    {
        return $this->prixTotal;
    }

    /**
     * @param string|null $prixTotal
     */
    public function setPrixTotal(?string $prixTotal): void
    {
        $this->prixTotal = $prixTotal;
    }



    /**
     * @return User
     */
    public function getIdclient(): ?User
    {
        return $this->idclient;
    }

    /**
     * @param User $idclient
     */
    public function setIdclient(User $idclient): void
    {
        $this->idclient = $idclient;
    }

    /**
     * @return Endroit
     */
    public function getMatricule(): ?Endroit
    {
        return $this->matricule;
    }

    /**
     * @param Endroit $matricule
     */
    public function setMatricule(Endroit $matricule): void
    {
        $this->matricule = $matricule;
    }


}
