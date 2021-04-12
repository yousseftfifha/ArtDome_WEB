<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exposition
 *
 * @ORM\Table(name="exposition", indexes={@ORM\Index(name="fk_idartiste", columns={"code_artiste"}), @ORM\Index(name="fk_idespace", columns={"code_espace"})})
 * @ORM\Entity
 */
class Exposition
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_expo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeExpo;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_expo", type="string", length=30, nullable=false)
     */
    private $nomExpo;

    /**
     * @var string
     *
     * @ORM\Column(name="theme_expo", type="string", length=30, nullable=false)
     */
    private $themeExpo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expo", type="date", nullable=false)
     */
    private $dateExpo;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_max_participant", type="integer", nullable=false)
     */
    private $nbMaxParticipant;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_artiste", referencedColumnName="ID")
     * })
     */
    private $codeArtiste;

    /**
     * @var \Endroit
     *
     * @ORM\ManyToOne(targetEntity="Endroit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_espace", referencedColumnName="id_endroit")
     * })
     */
    private $codeEspace;


}
