<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Cat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCat;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="NomCat", type="string", length=40, nullable=false)
     */
    private $nomcat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateCat", type="date", nullable=true)
     */
    private $datecat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="NbreOeuvre", type="integer", nullable=true)
     */
    private $nbreoeuvre = '0';


}
