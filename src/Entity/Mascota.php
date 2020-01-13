<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mascota
 *
 * @ORM\Table(name="mascota", indexes={@ORM\Index(name="usuario", columns={"usuario"})})
 * @ORM\Entity
 */
class Mascota
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechanacimiento", type="date", nullable=false)
     */
    private $fechanacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="especie", type="string", length=50, nullable=false)
     */
    private $especie;

    /**
     * @var string
     *
     * @ORM\Column(name="raza", type="string", length=50, nullable=false)
     */
    private $raza;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=50, nullable=false)
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="blob", length=0, nullable=true)
     */
    private $foto;

    /**
     * @var bool
     *
     * @ORM\Column(name="encelo", type="boolean", nullable=false)
     */
    private $encelo;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechanacimiento(): ?\DateTimeInterface
    {
        return $this->fechanacimiento;
    }

    public function setFechanacimiento(\DateTimeInterface $fechanacimiento): self
    {
        $this->fechanacimiento = $fechanacimiento;

        return $this;
    }

    public function getEspecie(): ?string
    {
        return $this->especie;
    }

    public function setEspecie(string $especie): self
    {
        $this->especie = $especie;

        return $this;
    }

    public function getRaza(): ?string
    {
        return $this->raza;
    }

    public function setRaza(string $raza): self
    {
        $this->raza = $raza;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getEncelo(): ?bool
    {
        return $this->encelo;
    }

    public function setEncelo(bool $encelo): self
    {
        $this->encelo = $encelo;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }


}
