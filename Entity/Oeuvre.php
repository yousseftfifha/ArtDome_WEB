<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Oeuvre
 *
 * @ORM\Table(name="oeuvre", indexes={@ORM\Index(name="fk_exposition", columns={"code_exposition"}), @ORM\Index(name="fk_id", columns={"ID_Artiste"})})
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\oeuvreRepository")php bin/console make:entity --regenerate
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
     * @Assert\Length(min=4)
     * @Assert\NotBlank
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
     * @ORM\Column(name="ImageOeuvre", type="string", length=255, nullable=true)
     */
    private $imageoeuvre;


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
     * @var string|null

     * @ORM\Column(name="NomCat", type="string", length=50, nullable=true)
     */
    private $nomcat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EmailArtiste", type="string", length=255, nullable=true)
     * @Assert\Email
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

    public function getIdOeuvre(): ?int
    {
        return $this->idOeuvre;
    }

    public function getNomoeuvre(): ?string
    {
        return $this->nomoeuvre;
    }

    public function setNomoeuvre(string $nomoeuvre): self
    {
        $this->nomoeuvre = $nomoeuvre;

        return $this;
    }

    public function getPrixoeuvre(): ?float
    {
        return $this->prixoeuvre;
    }

    public function setPrixoeuvre(float $prixoeuvre): self
    {
        $this->prixoeuvre = $prixoeuvre;

        return $this;
    }

    public function getDateoeuvre(): ?\DateTimeInterface
    {
        return $this->dateoeuvre;
    }

    public function setDateoeuvre(?\DateTimeInterface $dateoeuvre): self
    {
        $this->dateoeuvre = $dateoeuvre;

        return $this;
    }

    public function getImageoeuvre()
    {
        return $this->imageoeuvre;
    }

    public function setImageoeuvre($imageoeuvre)
    {
        $this->imageoeuvre = $imageoeuvre;

        return $this;
    }

    public function getNomcat(): ?string
    {
        return $this->nomcat;
    }

    public function setNomcat(?string $nomcat): self
    {
        $this->nomcat = $nomcat;

        return $this;
    }

    public function getEmailartiste(): ?string
    {
        return $this->emailartiste;
    }

    public function setEmailartiste(?string $emailartiste): self
    {
        $this->emailartiste = $emailartiste;

        return $this;
    }

    public function getCodeExposition(): ?Exposition
    {
        return $this->codeExposition;
    }

    public function setCodeExposition(?Exposition $codeExposition): self
    {
        $this->codeExposition = $codeExposition;

        return $this;
    }

    public function getIdArtiste(): ?User
    {
        return $this->idArtiste;
    }

    public function setIdArtiste(?User $idArtiste): self
    {
        $this->idArtiste = $idArtiste;

        return $this;
    }


}