<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PendingOrders
 *
 * @ORM\Table(name="pending_orders", indexes={@ORM\Index(name="fk_oeuvres", columns={"OeuvreID"}), @ORM\Index(name="fk_us", columns={"IDUser"})})
 * @ORM\Entity(repositoryClass="App\Repository\PendingOrdersRepository")
 */
class PendingOrders
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PendingOrder", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPendingorder;



    /**
     * @var int|null
     *
     * @ORM\Column(name="InnoNumber", type="integer", nullable=true)
     */
    private $innonumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;


    /**
     * @var Oeuvre
     *
     * @ORM\ManyToOne(targetEntity="Oeuvre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OeuvreID", referencedColumnName="ID_Oeuvre")
     * })
     */
    private $oeuvreid;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDUser", referencedColumnName="ID")
     * })
     */
    private $iduser;

    public function getIdPendingorder(): ?int
    {
        return $this->idPendingorder;
    }



    public function getInnonumber(): ?int
    {
        return $this->innonumber;
    }

    public function setInnonumber(?int $innonumber): self
    {
        $this->innonumber = $innonumber;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }



    public function getOeuvreid(): ?Oeuvre
    {
        return $this->oeuvreid;
    }

    public function setOeuvreid(?Oeuvre $oeuvreid): self
    {
        $this->oeuvreid = $oeuvreid;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
