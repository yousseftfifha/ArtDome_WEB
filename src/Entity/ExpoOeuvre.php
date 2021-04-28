<?php

namespace App\Entity;

use App\Repository\ExpoOeuvreRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ExpoOeuvreRepository::class)
 * @ORM\Entity(repositoryClass="App\Repository\ExpoOeuvreRepository")
 */
class ExpoOeuvre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var \Oeuvre
     *
     * @ORM\ManyToOne(targetEntity="Oeuvre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_oeuvre", referencedColumnName="ID_Oeuvre")
     * })
     */
    private $codeOeuvre;


    /**
     * @var \Exposition
     *
     * @ORM\ManyToOne(targetEntity="Exposition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="code_expo", referencedColumnName="code_expo")
     * })
     */
    private $codeExpo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return \Oeuvre
     */
    public function getCodeOeuvre(): \Oeuvre
    {
        return $this->codeOeuvre;
    }

    /**
     * @param \Oeuvre $codeOeuvre
     */
    public function setCodeOeuvre(\Oeuvre $codeOeuvre): void
    {
        $this->codeOeuvre = $codeOeuvre;
    }

    /**
     * @return \Exposition
     */
    public function getCodeExpo(): \Exposition
    {
        return $this->codeExpo;
    }

    /**
     * @param \Exposition $codeExpo
     */
    public function setCodeExpo(\Exposition $codeExpo): void
    {
        $this->codeExpo = $codeExpo;
    }


}
