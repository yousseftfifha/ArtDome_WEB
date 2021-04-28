<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Endroit
 *
 * @ORM\Table(name="endroit")
 * @ORM\Entity
 */
class Endroit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_endroit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEndroit;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="taille", type="integer", nullable=false)
     */
    private $taille;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_jour", type="integer", nullable=false)
     */
    private $prixJour;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrch", type="integer", nullable=false)
     */
    private $nbrch;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var string|null
     *
     * @ORM\Column(name="disponibilite", type="string", length=30, nullable=true)
     */
    private $disponibilite;


}
