<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="fk_artiste", columns={"code_artiste"}), @ORM\Index(name="fk_espace", columns={"code_espace"})})
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */


class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("events:read")
     */
    private $codeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_event", type="string", length=30, nullable=false)
     *@Assert\NotBlank(message="Event name is required")
     *@Groups("events:read")
     */
    private $nomEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="theme_event", type="string", length=30, nullable=false)
     *@Assert\NotBlank(message="Event theme is required")
     * @Groups("events:read")
     */
    private $themeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     *@Assert\NotBlank(message="Event state is required")
     * @Groups("events:read")
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     *@Assert\NotBlank(message="Event date is required")
     * @Groups("events:read")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_max_part", type="integer", nullable=false)
     *@Assert\NotBlank(message="Event participation range is required")
     * @Assert\Positive(message="This field value must be positive")
     * @Assert\Type(
     *     type="integer",
     *     message="This field must be of numeric type."
     * )
     * @Groups("events:read")
     */
    private $nbMaxPart;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     *@Assert\NotBlank(message="Event picture is required")
     * @Groups("events:read")
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     *@Assert\NotBlank(message="Event video is required")
     * @Groups("events:read")
     */
    private $video;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_artiste", referencedColumnName="ID")
     * })
     *@Assert\NotBlank(message="Artiste code is required")
     * @Groups("events:read")
     */
    private $codeArtiste;

    /**
     * @var Endroit
     *
     * @ORM\ManyToOne(targetEntity="Endroit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_espace", referencedColumnName="id_endroit")
     * })
     *@Assert\NotBlank(message="Place code is required")
     * @Groups("events:read")
     */


    private $codeEspace;

    /**
     * @return Endroit
     */
    public function getCodeEspace(): ?Endroit
    {
        return $this->codeEspace;
    }

    /**
     * @param Endroit $codeEspace
     */
    public function setCodeEspace(Endroit $codeEspace): void
    {
        $this->codeEspace = $codeEspace;
    }

    /**
     * @return int
     */
    public function getCodeEvent(): ?int
    {
        return $this->codeEvent;
    }

    /**
     * @param int $codeEvent
     */
    public function setCodeEvent(int $codeEvent): void
    {
        $this->codeEvent = $codeEvent;
    }

    /**
     * @return string
     */
    public function getNomEvent(): ?string
    {
        return $this->nomEvent;
    }

    /**
     * @param string $nomEvent
     */
    public function setNomEvent(string $nomEvent): void
    {
        $this->nomEvent = $nomEvent;
    }

    /**
     * @return string
     */
    public function getThemeEvent(): ?string
    {
        return $this->themeEvent;
    }

    /**
     * @param string $themeEvent
     */
    public function setThemeEvent(string $themeEvent): void
    {
        $this->themeEvent = $themeEvent;
    }

    /**
     * @return string
     */
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getNbMaxPart(): ?int
    {
        return $this->nbMaxPart;
    }

    /**
     * @param int $nbMaxPart
     */
    public function setNbMaxPart(int $nbMaxPart): void
    {
        $this->nbMaxPart = $nbMaxPart;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string|null $video
     */
    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    /**
     * @return User
     */
    public function getCodeArtiste(): ?User
    {
        return $this->codeArtiste;
    }

    /**
     * @param User $codeArtiste
     */
    public function setCodeArtiste(User $codeArtiste): void
    {
        $this->codeArtiste = $codeArtiste;
    }



}
