<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="fk_idblog", columns={"idBlog"}), @ORM\Index(name="fk_iduser", columns={"Id_User"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Assert\Length(min=2)
     */
    private $idComment;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=false)

     * @Assert\Length(min=5)
     */
    private $text;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="CreatedAt", type="datetime_immutable", nullable=false)
     */
    private  $createdat;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="UpdatedAt", type="datetime_immutable", nullable=false)
     */
    private $updatedat;

    /**
     * @var Blog
     *
     * @ORM\ManyToOne(targetEntity="Blog")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idBlog", referencedColumnName="idBlog")
     * })
     */
    private $idBlog;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="ID")
     * })
     */
    private $idUser;

    /**
     * @return int
     */
    public function getIdComment():? int
    {
        return $this->idComment;
    }

    /**
     * @param int $idComment
     */
    public function setIdComment(int $idComment): void
    {
        $this->idComment = $idComment;
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedat():? \DateTimeImmutable
    {
        return $this->createdat;
    }

    /**
     * @param \DateTimeImmutable $createdat
     */
    public function setCreatedat(\DateTimeImmutable $createdat): void
    {
        $this->createdat = $createdat;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedat(): ?\DateTimeImmutable
    {
        return $this->updatedat;
    }

    /**
     * @param \DateTimeImmutable $updatedat
     */
    public function setUpdatedat(\DateTimeImmutable $updatedat): void
    {
        $this->updatedat = $updatedat;
    }

    /**
     * @return Blog
     */
    public function getIdBlog(): ?Blog
    {
        return $this->idBlog;
    }

    /**
     * @param Blog $idBlog
     */
    public function setIdBlog(Blog $idBlog): void
    {
        $this->idBlog = $idBlog;
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





}
