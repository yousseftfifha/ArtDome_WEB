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

    public function getCodeExpo(): ?int
    {
        return $this->codeExpo;
    }

    public function getNomExpo(): ?string
    {
        return $this->nomExpo;
    }

    public function setNomExpo(string $nomExpo): self
    {
        $this->nomExpo = $nomExpo;

        return $this;
    }

    public function getThemeExpo(): ?string
    {
        return $this->themeExpo;
    }

    public function setThemeExpo(string $themeExpo): self
    {
        $this->themeExpo = $themeExpo;

        return $this;
    }

    public function getDateExpo(): ?\DateTimeInterface
    {
        return $this->dateExpo;
    }

    public function setDateExpo(\DateTimeInterface $dateExpo): self
    {
        $this->dateExpo = $dateExpo;

        return $this;
    }

    public function getNbMaxParticipant(): ?int
    {
        return $this->nbMaxParticipant;
    }

    public function setNbMaxParticipant(int $nbMaxParticipant): self
    {
        $this->nbMaxParticipant = $nbMaxParticipant;

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
