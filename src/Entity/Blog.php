<?php

namespace App\Entity;

//use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Categorie;
use Symfony\Component\Validator\Constraints as Assert;

//use Symfony\Component\Validator\Constraints as Assert;

/**
 * Blog
 *
 * @ORM\Entity(repositoryClass="App\Repository\BlogRepository")
 * @ORM\Table(name="blog", uniqueConstraints={@ORM\UniqueConstraint(name="blog_titres_uindex", columns={"Title"})}, indexes={@ORM\Index(name="fk_categorie", columns={"Categorie"}),@ORM\Index(name="fk_xxx", columns={"User"})})
 *
 *
 */
class Blog
{
    /**
     * @var string|null
     * @Assert\NotBlank
     * @ORM\Column(name="Title", type="string", length=100, nullable=false, options={"default"="','"})
     */
    private  $title = null;
    //   private $title = '\',\'';

    /**
     * @var DateTimeImmutable
     * @ORM\Column(name="DateOfPub", type="datetime_immutable", nullable=false)
     */
    private  $dateofpub;

    /**
     * @var string|null
     * @ORM\Column(name="Image", type="text", length=0, nullable=true)
     */
    private $image = null;

    /**
     * @var string
     * @ORM\Column(name="Description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     * @ORM\Column(name="Publisher", type="string", length=40, nullable=true, options={"default"="NULL"})
     */
    private $publisher = 'NULL';

    /**
     * @var int/null
     * @ORM\Column(name="idBlog", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $idblog;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="idblog")
     */
    private $commentaires;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="ID")
     * })
     */
    private  $user;

    /**
     * @return User
     */
    public function getUser(): ?User
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
     * @var categorie
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Categorie", referencedColumnName="ID_Cat")
     * })
     */
    private $categorie;

    /**
     * Post constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->dateofpub = new DateTimeImmutable();
        $this->commentaires = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;


    }

    public function getDateofpub(): DateTimeImmutable
    {
        return $this->dateofpub;
    }

    public function setDateofpub(DateTimeImmutable $dateofpub): void
    {
        $this->dateofpub = $dateofpub;


    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;


    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;

    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): void
    {
        $this->publisher = $publisher;

    }

    public function getIdblog(): ?int
    {
        return $this->idblog;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;

    }

    /**
     * @return Collection
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }


}
