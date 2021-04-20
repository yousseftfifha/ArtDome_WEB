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

    public function getCodeEvent(): ?int
    {
        return $this->codeEvent;
    }

    public function getNomEvent(): ?string
    {
        return $this->nomEvent;
    }

    public function setNomEvent(string $nomEvent): self
    {
        $this->nomEvent = $nomEvent;

        return $this;
    }

    public function getThemeEvent(): ?string
    {
        return $this->themeEvent;
    }

    public function setThemeEvent(string $themeEvent): self
    {
        $this->themeEvent = $themeEvent;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbMaxPart(): ?int
    {
        return $this->nbMaxPart;
    }

    public function setNbMaxPart(int $nbMaxPart): self
    {
        $this->nbMaxPart = $nbMaxPart;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCodeArtiste(): ?User
    {
        return $this->codeArtiste;
    }

    public function setCodeArtiste(?User $codeArtiste): self
    {
        $this->codeArtiste = $codeArtiste;

        return $this;
    }

    public function getCodeEspace(): ?Endroit
    {
        return $this->codeEspace;
    }

    public function setCodeEspace(?Endroit $codeEspace): self
    {
        $this->codeEspace = $codeEspace;

        return $this;
    }


}
