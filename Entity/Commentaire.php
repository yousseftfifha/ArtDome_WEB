<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="fk_idblog", columns={"id_blog"}), @ORM\Index(name="fk_iduser", columns={"Id_User"})})
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
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     */
    private $idComment;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min=5)
     */
    private $text;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="CreatedAt", type="datetime_immutable", nullable=false)
     */
    private  $createdat;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="UpdatedAt", type="datetime_immutable", nullable=false)
     */
    private $updatedat;

    /**
     * @var \Blog
     *
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="commentaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_blog", referencedColumnName="idBlog")
     * })
     */
    private $idBlog;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="ID")
     * })
     */
    private $idUser;

    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeImmutable
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeImmutable $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeImmutable
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTimeImmutable $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getIdBlog(): ?Blog
    {
        return $this->idBlog;
    }

    public function setIdBlog(?Blog $idBlog): self
    {
        $this->idBlog = $idBlog;

        return $this;
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
