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

    public function __toString() {
        return $this->idEndroit.' ';
    }

    /**
     * @return int
     */
    public function getIdEndroit(): int
    {
        return $this->idEndroit;
    }

    /**
     * @param int $idEndroit
     */
    public function setIdEndroit(int $idEndroit): void
    {
        $this->idEndroit = $idEndroit;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getTaille(): int
    {
        return $this->taille;
    }

    /**
     * @param int $taille
     */
    public function setTaille(int $taille): void
    {
        $this->taille = $taille;
    }

    /**
     * @return int
     */
    public function getPrixJour(): int
    {
        return $this->prixJour;
    }

    /**
     * @param int $prixJour
     */
    public function setPrixJour(int $prixJour): void
    {
        $this->prixJour = $prixJour;
    }

    /**
     * @return int
     */
    public function getNbrch(): int
    {
        return $this->nbrch;
    }

    /**
     * @param int $nbrch
     */
    public function setNbrch(int $nbrch): void
    {
        $this->nbrch = $nbrch;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string|null
     */
    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    /**
     * @param string|null $disponibilite
     */
    public function setDisponibilite(?string $disponibilite): void
    {
        $this->disponibilite = $disponibilite;
    }


}
