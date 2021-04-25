<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationExpo
 *
 * @ORM\Table(name="reservation_expo", indexes={@ORM\Index(name="fk_clients", columns={"code_client"}), @ORM\Index(name="fk_expo", columns={"code_expo"})})
 * @ORM\Entity
 */
class ReservationExpo
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_reservationE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeReservatione;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=true)
     */
    private $nbPlace;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_client", referencedColumnName="ID")
     * })
     */
    private $codeClient;

    /**
     * @var \Exposition
     *
     * @ORM\ManyToOne(targetEntity="Exposition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_expo", referencedColumnName="code_expo")
     * })
     */
    private $codeExpo;

    public function getCodeReservatione(): ?int
    {
        return $this->codeReservatione;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(?int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getCodeClient(): ?User
    {
        return $this->codeClient;
    }

    public function setCodeClient(?User $codeClient): self
    {
        $this->codeClient = $codeClient;

        return $this;
    }

    public function getCodeExpo(): ?Exposition
    {
        return $this->codeExpo;
    }

    public function setCodeExpo(?Exposition $codeExpo): self
    {
        $this->codeExpo = $codeExpo;

        return $this;
    }


}
