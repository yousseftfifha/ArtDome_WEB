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


}
