<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oeuvre
 *
 * @ORM\Table(name="oeuvre", indexes={@ORM\Index(name="fk_exposition", columns={"code_exposition"}), @ORM\Index(name="fk_id", columns={"ID_Artiste"})})
 * @ORM\Entity
 */
class Oeuvre
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Oeuvre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOeuvre;

    /**
     * @var string
     *
     * @ORM\Column(name="NomOeuvre", type="string", length=30, nullable=false)
     */
    private $nomoeuvre;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixOeuvre", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixoeuvre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateOeuvre", type="date", nullable=true)
     */
    private $dateoeuvre;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageOeuvre", type="string", length=255, nullable=false)
     */
    private $imageoeuvre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NomCat", type="string", length=50, nullable=true)
     */
    private $nomcat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EmailArtiste", type="string", length=255, nullable=true)
     */
    private $emailartiste;

    /**
     * @var \Exposition
     *
     * @ORM\ManyToOne(targetEntity="Exposition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_exposition", referencedColumnName="code_expo")
     * })
     */
    private $codeExposition;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Artiste", referencedColumnName="ID")
     * })
     */
    private $idArtiste;


}
