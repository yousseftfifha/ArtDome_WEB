<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\NotBlank (message="veuillez s'il vous-plais remplir ce champ")
     * @Assert\Positive (message="cette valeur doit être positive")
     */
    private $nbPlace;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_client", referencedColumnName="ID")
     * })
     * @Assert\NotBlank (message="veuillez s'il vous-plais remplir ce champ")
     * @Assert\Positive (message="cette valeur doit être positive")
     */
    private $codeClient;

    /**
     * @var Exposition
     *
     * @ORM\ManyToOne(targetEntity="Exposition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_expo", referencedColumnName="code_expo")
     * })
     * @Assert\NotBlank (message="veuillez s'il vous-plais remplir ce champ")
     * @Assert\Positive (message="cette valeur doit être positive")
     */
    private $codeExpo;

    /**
     * @return int
     */
    public function getCodeReservatione(): ?int
    {
        return $this->codeReservatione;
    }

    /**
     * @param int $codeReservatione
     */
    public function setCodeReservatione(int $codeReservatione): void
    {
        $this->codeReservatione = $codeReservatione;
    }

    /**
     * @return int|null
     */
    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    /**
     * @param int|null $nbPlace
     */
    public function setNbPlace(?int $nbPlace): void
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
     * @return Exposition
     */
    public function getCodeExpo(): ?Exposition
    {
        return $this->codeExpo;
    }

    /**
     * @param Exposition $codeExpo
     */
    public function setCodeExpo(Exposition $codeExpo): void
    {
        $this->codeExpo = $codeExpo;
    }


}
