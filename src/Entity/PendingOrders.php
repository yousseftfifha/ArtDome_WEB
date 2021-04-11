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


}
