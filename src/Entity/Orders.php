<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="fk_u", columns={"IDUser"})})
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")

 */
class Orders
{
    /**
     * @var int
     * @Groups("orders:read")
     * @ORM\Column(name="OrderID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("orders:read")
     */
    private $orderid;

    /**
     * @var float
     * @Groups("orders:read")
     * @ORM\Column(name="DueAmount", type="float", precision=10, scale=0, nullable=false)
     */
    private $dueamount;

    /**
     * @var int
     *
     * @ORM\Column(name="InnoNumber", type="integer", nullable=false)
     * @Groups("orders:read")
     */
    private $innonumber;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="OrderDate", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @Groups("orders:read")
     */
    private $orderdate = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=30, nullable=false)
     * @Groups("orders:read")
     */
    private $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDUser", referencedColumnName="ID")
     * })
     * @Groups("orders:read")
     */
    private $iduser;

    public function getOrderid(): ?int
    {
        return $this->orderid;
    }

    public function getDueamount(): ?float
    {
        return $this->dueamount;
    }

    public function setDueamount(float $dueamount): self
    {
        $this->dueamount = $dueamount;

        return $this;
    }

    public function getInnonumber(): ?int
    {
        return $this->innonumber;
    }

    public function setInnonumber(int $innonumber): self
    {
        $this->innonumber = $innonumber;

        return $this;
    }



    public function getOrderdate(): ?\DateTimeInterface
    {
        return $this->orderdate;
    }

    public function setOrderdate(\DateTimeInterface $orderdate): self
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
