<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenaissance", type="date", nullable=false)
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=30, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", nullable=false)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=80, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=30, nullable=true, options={"default"="user"})
     */
    private $role = 'user';

    /**
     * @var string|null
     *
     * @ORM\Column(name="mdp", type="string", length=50, nullable=true)
     */
    private $mdp;

    /**
     * User constructor.
     * @param int $id
     * @param string $nom
     * @param string $prenom
     * @param \DateTime $datenaissance
     * @param string $ville
     * @param string $email
     * @param int $numero
     * @param string|null $image
     * @param string|null $role
     * @param string|null $mdp
     */
    public function __construct(int $id, string $nom, string $prenom, \DateTime $datenaissance, string $ville, string $email, int $numero, ?string $image, ?string $role, ?string $mdp)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->datenaissance = $datenaissance;
        $this->ville = $ville;
        $this->email = $email;
        $this->numero = $numero;
        $this->image = $image;
        $this->role = $role;
        $this->mdp = $mdp;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return \DateTime
     */
    public function getDatenaissance(): \DateTime
    {
        return $this->datenaissance;
    }

    /**
     * @param \DateTime $datenaissance
     */
    public function setDatenaissance(\DateTime $datenaissance): void
    {
        $this->datenaissance = $datenaissance;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
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
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string|null
     */
    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    /**
     * @param string|null $mdp
     */
    public function setMdp(?string $mdp): void
    {
        $this->mdp = $mdp;
    }
    public function __toString() {
        return $this->id.' ';
    }

}
