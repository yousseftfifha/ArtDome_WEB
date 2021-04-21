<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="fk_cart", columns={"id_user"})})
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="OeuvreId", type="integer", nullable=false)
     */
    private $oeuvreid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NomOeuvre", type="string", length=30, nullable=true)
     */
    private $nomoeuvre;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="IDcart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcart;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="ID")
     * })
     */
    private $idUser;

    public function getOeuvreid(): ?int
    {
        return $this->oeuvreid;
    }

    public function setOeuvreid(int $oeuvreid): self
    {
        $this->oeuvreid = $oeuvreid;

        return $this;
    }

    public function getNomoeuvre(): ?string
    {
        return $this->nomoeuvre;
    }

    public function setNomoeuvre(?string $nomoeuvre): self
    {
        $this->nomoeuvre = $nomoeuvre;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getIdcart(): ?int
    {
        return $this->idcart;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
