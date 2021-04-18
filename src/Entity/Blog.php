<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 *
 * @ORM\Table(name="blog", uniqueConstraints={@ORM\UniqueConstraint(name="blog_titres_uindex", columns={"Title"})}, indexes={@ORM\Index(name="fk_categorie", columns={"Categorie"})})
 * @ORM\Entity
 */
class Blog
{
    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=100, nullable=false, options={"default"=","})
     */
    private $title = ',';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateOfPub", type="date", nullable=false)
     */
    private $dateofpub;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="text", length=0, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Publisher", type="string", length=40, nullable=true)
     */
    private $publisher;

    /**
     * @var int
     *
     * @ORM\Column(name="idBlog", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idblog;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Categorie", referencedColumnName="ID_Cat")
     * })
     */
    private $categorie;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateofpub(): ?\DateTimeInterface
    {
        return $this->dateofpub;
    }

    public function setDateofpub(\DateTimeInterface $dateofpub): self
    {
        $this->dateofpub = $dateofpub;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getIdblog(): ?int
    {
        return $this->idblog;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }


}
