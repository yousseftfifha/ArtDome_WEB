<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="fk_artiste", columns={"code_artiste"}), @ORM\Index(name="fk_espace", columns={"code_espace"})})
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_event", type="string", length=30, nullable=false)
     */
    private $nomEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="theme_event", type="string", length=30, nullable=false)
     */
    private $themeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_max_part", type="integer", nullable=false)
     */
    private $nbMaxPart;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

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
