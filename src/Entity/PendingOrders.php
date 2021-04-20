<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PendingOrders
 *
 * @ORM\Table(name="pending_orders", indexes={@ORM\Index(name="fk_us", columns={"IDUser"})})
 * @ORM\Entity
 */
class PendingOrders
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="InnoNumber", type="integer", nullable=true)
     */
    private $innonumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="OeuvreID", type="integer", nullable=true)
     */
    private $oeuvreid;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Status", type="string", length=30, nullable=true)
     */
    private $status;

    /**
     * @var \Orders
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="OrderID", referencedColumnName="OrderID")
     * })
     */
    private $orderid;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDUser", referencedColumnName="ID")
     * })
     */
    private $iduser;

    public function getInnonumber(): ?int
    {
        return $this->innonumber;
    }

    public function setInnonumber(?int $innonumber): self
    {
        $this->innonumber = $innonumber;

        return $this;
    }

    public function getOeuvreid(): ?int
    {
        return $this->oeuvreid;
    }

    public function setOeuvreid(?int $oeuvreid): self
    {
        $this->oeuvreid = $oeuvreid;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderid(): ?Orders
    {
        return $this->orderid;
    }

    public function setOrderid(?Orders $orderid): self
    {
        $this->orderid = $orderid;

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
