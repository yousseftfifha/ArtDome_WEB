<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservationevent
 *
 * @ORM\Table(name="reservationevent", indexes={@ORM\Index(name="fk_client", columns={"code_client"}), @ORM\Index(name="fk_event", columns={"code_event"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReservationeventRepository")
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
     *@Assert\NotBlank(message="You should at least book one place")
     *@Assert\Positive(message="This field value must be positive")
     * @Assert\Type(
     *     type="integer",
     *     message="This field must be of numeric type."
     * )
     */
    private $nbPlace;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_client", referencedColumnName="ID")
     * })
     *@Assert\NotBlank(message="Client code is required")
     */
    private $codeClient;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_event", referencedColumnName="code_event")
     * })
     *@Assert\NotBlank(message="Event name is required")
     */
    private $codeEvent;

    /**
     * @return int
     */
    public function getCodeReservation(): ?int
    {
        return $this->codeReservation;
    }

    /**
     * @param int $codeReservation
     */
    public function setCodeReservation(int $codeReservation): void
    {
        $this->codeReservation = $codeReservation;
    }

    /**
     * @return int
     */
    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    /**
     * @param int $nbPlace
     */
    public function setNbPlace(int $nbPlace): void
    {
        $this->nbPlace = $nbPlace;
    }

    /**
     * @return User
     */
    public function getCodeClient(): ?User
    {
        return $this->codeClient;
    }

    /**
     * @param User $codeClient
     */
    public function setCodeClient(User $codeClient): void
    {
        $this->codeClient = $codeClient;
    }

    /**
     * @return Event
     */
    public function getCodeEvent(): ?Event
    {
        return $this->codeEvent;
    }

    /**
     * @param Event $codeEvent
     */
    public function setCodeEvent(Event $codeEvent): void
    {
        $this->codeEvent = $codeEvent;
    }


}
