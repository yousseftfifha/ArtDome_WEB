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

    public function getIdCat(): ?int
    {
        return $this->idCat;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNomcat(): ?string
    {
        return $this->nomcat;
    }

    public function setNomcat(string $nomcat): self
    {
        $this->nomcat = $nomcat;

        return $this;
    }

    public function getDatecat(): ?\DateTimeInterface
    {
        return $this->datecat;
    }

    public function setDatecat(?\DateTimeInterface $datecat): self
    {
        $this->datecat = $datecat;

        return $this;
    }

    public function getNbreoeuvre(): ?int
    {
        return $this->nbreoeuvre;
    }

    public function setNbreoeuvre(?int $nbreoeuvre): self
    {
        $this->nbreoeuvre = $nbreoeuvre;

        return $this;
    }


}
