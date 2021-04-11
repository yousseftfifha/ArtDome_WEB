<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="fk_oeuvre", columns={"OeuvreId"}), @ORM\Index(name="fk_cart", columns={"id_user"})})
 * @ORM\Entity

 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDcart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcart;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=false, options={"default"="1"})
     */
    private $quantity = '1';

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="ID")
     * })
     */
    private $idUser;

    /**
     * @var Oeuvre
     *
     * @ORM\ManyToOne(targetEntity="Oeuvre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OeuvreId", referencedColumnName="ID_Oeuvre")
     * })
     */
    private $oeuvreid;


    /**
     * @return int
     */
    public function getIdcart(): int
    {
        return $this->idcart;
    }

    /**
     * @param int $idcart
     */
    public function setIdcart(int $idcart): void
    {
        $this->idcart = $idcart;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return User
     */
    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser(User $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return Oeuvre
     */
    public function getOeuvreid(): ?Oeuvre
    {
        return $this->oeuvreid;
    }

    /**
     * @param Oeuvre $oeuvreid
     */
    public function setOeuvreid(Oeuvre $oeuvreid): void
    {
        $this->oeuvreid = $oeuvreid;
    }


}
