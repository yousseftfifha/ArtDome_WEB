<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Blog
 * * @ORM\Table(name="blog", uniqueConstraints={@ORM\UniqueConstraint(name="blog_titres_uindex", columns={"Title"})}, indexes={@ORM\Index(name="fk_categorie", columns={"Categorie"})})
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 */
class Blog
{
    /**
     * @var string|null
     *@Assert\NotBlank
     * @ORM\Column(name="Title", type="string", length=100, nullable=false, options={"default"=","})
     */
    private $title = ',';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="string", length=50, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Publisher", type="string", length=40, nullable=true)
     */
    private $publisher;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idBlog", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idblog;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Categorie", referencedColumnName="ID_Cat")
     * })
     */
    private $categorie;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="blog")
     */
    private $commentaires;
    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     */

    private $dateOfPub;

    /**
     * Blog constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->dateOfPub = new DateTimeImmutable();
        $this->commentaires = new ArrayCollection();
    }


    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateOfPub(): DateTimeImmutable
    {
        return $this->dateOfPub;
    }

    /**
     * @param DateTimeImmutable $dateOfPub
     */
    public function setDateOfPub(DateTimeImmutable $dateOfPub): void
    {
        $this->dateOfPub = $dateOfPub;
    }



    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * @param string|null $publisher
     */
    public function setPublisher(?string $publisher): void
    {
        $this->publisher = $publisher;
    }

    /**
     * @return int|null
     */
    public function getIdblog(): ?int
    {
        return $this->idblog;
    }

    /**
     * @param int|null $idblog
     */
    public function setIdblog(?int $idblog): void
    {
        $this->idblog = $idblog;
    }

    /**
     * @return Categorie
     */
    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    /**
     * @param Collection $commentaires
     */
    public function setCommentaires(Collection $commentaires): void
    {
        $this->commentaires = $commentaires;
    }



}
