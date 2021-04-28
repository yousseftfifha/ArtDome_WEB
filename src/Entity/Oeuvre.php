<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

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
     * @var Exposition
     *
     * @ORM\ManyToOne(targetEntity="Exposition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_exposition", referencedColumnName="code_expo")
     * })
     */
    private $codeExposition;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Artiste", referencedColumnName="ID")
     * })
     */
    private $idArtiste;


    /**
     * @return int
     */
    public function getIdOeuvre(): int
    {
        return $this->idOeuvre;
    }

    /**
     * @param int $idOeuvre
     */
    public function setIdOeuvre(int $idOeuvre): void
    {
        $this->idOeuvre = $idOeuvre;
    }

    /**
     * @return string
     */
    public function getNomoeuvre(): ?string
    {
        return $this->nomoeuvre;
    }

    /**
     * @param string $nomoeuvre
     */
    public function setNomoeuvre(string $nomoeuvre): void
    {
        $this->nomoeuvre = $nomoeuvre;
    }

    /**
     * @return float
     */
    public function getPrixoeuvre(): ?float
    {
        return $this->prixoeuvre;
    }

    /**
     * @param float $prixoeuvre
     */
    public function setPrixoeuvre(float $prixoeuvre): void
    {
        $this->prixoeuvre = $prixoeuvre;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateoeuvre(): ?\DateTime
    {
        return $this->dateoeuvre;
    }

    /**
     * @param \DateTime|null $dateoeuvre
     */
    public function setDateoeuvre(?\DateTime $dateoeuvre): void
    {
        $this->dateoeuvre = $dateoeuvre;
    }

    /**
     * @return string
     */
    public function getImageoeuvre(): ?string
    {
        return $this->imageoeuvre;
    }

    /**
     * @param string $imageoeuvre
     */
    public function setImageoeuvre(string $imageoeuvre): void
    {
        $this->imageoeuvre = $imageoeuvre;
    }

    /**
     * @return string|null
     */
    public function getNomcat(): ?string
    {
        return $this->nomcat;
    }

    /**
     * @param string|null $nomcat
     */
    public function setNomcat(?string $nomcat): void
    {
        $this->nomcat = $nomcat;
    }

    /**
     * @return string|null
     */
    public function getEmailartiste(): ?string
    {
        return $this->emailartiste;
    }

    /**
     * @param string|null $emailartiste
     */
    public function setEmailartiste(?string $emailartiste): void
    {
        $this->emailartiste = $emailartiste;
    }

    /**
     * @return Exposition
     */
    public function getCodeExposition(): ?Exposition
    {
        return $this->codeExposition;
    }

    /**
     * @param Exposition $codeExposition
     */
    public function setCodeExposition(Exposition $codeExposition): void
    {
        $this->codeExposition = $codeExposition;
    }

    /**
     * @return User
     */
    public function getIdArtiste(): User
    {
        return $this->idArtiste;
    }

    /**
     * @param User $idArtiste
     */
    public function setIdArtiste(User $idArtiste): void
    {
        $this->idArtiste = $idArtiste;
    }
    public function __toString() {
        return $this->idOeuvre.' ';
    }
    /**
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="ImageOeuvre")
     */
    private $imageFile;

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        return $this;

        /*if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }*/
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
