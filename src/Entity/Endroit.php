<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Endroit
 *
 * @ORM\Table(name="endroit")
 * @ORM\Entity
 */
class Endroit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_endroit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEndroit;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="taille", type="integer", nullable=false)
     */
    private $taille;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_jour", type="integer", nullable=false)
     */
    private $prixJour;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrch", type="integer", nullable=false)
     */
    private $nbrch;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var string|null
     *
     * @ORM\Column(name="disponibilite", type="string", length=30, nullable=true)
     */
    private $disponibilite;

    public function getIdEndroit(): ?int
    {
        return $this->idEndroit;
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

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPrixJour(): ?int
    {
        return $this->prixJour;
    }

    public function setPrixJour(int $prixJour): self
    {
        $this->prixJour = $prixJour;

        return $this;
    }

    public function getNbrch(): ?int
    {
        return $this->nbrch;
    }

    public function setNbrch(int $nbrch): self
    {
        $this->nbrch = $nbrch;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?string $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }


}
