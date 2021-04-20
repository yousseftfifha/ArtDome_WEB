<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Exposition
 *
 * @ORM\Table(name="exposition", indexes={@ORM\Index(name="fk_idartiste", columns={"code_artiste"}), @ORM\Index(name="fk_idespace", columns={"code_espace"})})
 * @ORM\Entity(repositoryClass="App\Repository\ExpositionRepository")
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
     * @Assert\NotBlank(message="veuillez s'il vous-plais remplir ce champ")
     */
    private $nomExpo;

    /**
     * @var string
     *
     * @ORM\Column(name="theme_expo", type="string", length=30, nullable=false)
     * @Assert\NotBlank(message="veuillez s'il vous-plais remplir ce champ")
     */
    private $themeExpo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_expo", type="date", nullable=false)
     * @Assert\NotBlank(message="veuillez s'il vous-plais remplir ce champ")
     */
    private $dateExpo;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_max_participant", type="integer", nullable=false)
     * @Assert\NotBlank(message="veuillez s'il vous-plais remplir ce champ")
     * @Assert\Positive(message="cette valeur doit être positive")
     * @Assert\Type(
     *     type="integer",
     *     message="Ce champ doit contenir un nombre."
     * )
     */
    private $nbMaxParticipant;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_artiste", referencedColumnName="ID")
     * })
     * @Assert\NotBlank(message="veuillez s'il vous-plais remplir ce champ")
     */
    private $codeArtiste;

    /**
     * @var Endroit
     *
     * @ORM\ManyToOne(targetEntity="Endroit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_espace", referencedColumnName="id_endroit")
     * })
     * @Assert\NotBlank(message="veuillez s'il vous-plais remplir ce champ")
     */
    private $codeEspace;

    /**
     * @return int
     */
    public function getCodeExpo(): ?int
    {
        return $this->codeExpo;
    }

    /**
     * @param int $codeExpo
     */
    public function setCodeExpo(int $codeExpo): void
    {
        $this->codeExpo = $codeExpo;
    }

    /**
     * @return string
     */
    public function getNomExpo(): ?string
    {
        return $this->nomExpo;
    }

    /**
     * @param string $nomExpo
     */
    public function setNomExpo(string $nomExpo): void
    {
        $this->nomExpo = $nomExpo;
    }

    /**
     * @return string
     */
    public function getThemeExpo(): ?string
    {
        return $this->themeExpo;
    }

    /**
     * @param string $themeExpo
     */
    public function setThemeExpo(string $themeExpo): void
    {
        $this->themeExpo = $themeExpo;
    }

    /**
     * @return \DateTime
     */
    public function getDateExpo(): ?\DateTime
    {
        return $this->dateExpo;
    }

    /**
     * @param \DateTime $dateExpo
     */
    public function setDateExpo(\DateTime $dateExpo): void
    {
        $this->dateExpo = $dateExpo;
    }

    /**
     * @return int
     */
    public function getNbMaxParticipant(): ?int
    {
        return $this->nbMaxParticipant;
    }

    /**
     * @param int $nbMaxParticipant
     */
    public function setNbMaxParticipant(int $nbMaxParticipant): void
    {
        $this->nbMaxParticipant = $nbMaxParticipant;
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

    public function __toString() {
        return $this->codeExpo.' ';
    }


}