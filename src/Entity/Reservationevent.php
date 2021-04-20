<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservationevent
 *
 * @ORM\Table(name="reservationevent", indexes={@ORM\Index(name="fk_client", columns={"code_client"}), @ORM\Index(name="fk_event", columns={"code_event"})})
 * @ORM\Entity
 */
class Reservationevent
{
    /**
     * @var int
     *
     * @ORM\Column(name="code_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
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
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_event", referencedColumnName="code_event")
     * })
     */
    private $codeEvent;

    public function getCodeReservation(): ?int
    {
        return $this->codeReservation;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
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

    public function getCodeEvent(): ?Event
    {
        return $this->codeEvent;
    }

    public function setCodeEvent(?Event $codeEvent): self
    {
        $this->codeEvent = $codeEvent;

        return $this;
    }


}
