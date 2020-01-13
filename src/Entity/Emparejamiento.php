<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emparejamiento
 *
 * @ORM\Table(name="emparejamiento", indexes={@ORM\Index(name="evento", columns={"evento"}), @ORM\Index(name="hembra", columns={"hembra"}), @ORM\Index(name="macho", columns={"macho"})})
 * @ORM\Entity
 */
class Emparejamiento
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
     * @var \Mascota
     *
     * @ORM\ManyToOne(targetEntity="Mascota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="macho", referencedColumnName="id")
     * })
     */
    private $macho;

    /**
     * @var \Mascota
     *
     * @ORM\ManyToOne(targetEntity="Mascota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hembra", referencedColumnName="id")
     * })
     */
    private $hembra;

    /**
     * @var \Evento
     *
     * @ORM\ManyToOne(targetEntity="Evento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evento", referencedColumnName="id")
     * })
     */
    private $evento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMacho(): ?Mascota
    {
        return $this->macho;
    }

    public function setMacho(?Mascota $macho): self
    {
        $this->macho = $macho;

        return $this;
    }

    public function getHembra(): ?Mascota
    {
        return $this->hembra;
    }

    public function setHembra(?Mascota $hembra): self
    {
        $this->hembra = $hembra;

        return $this;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): self
    {
        $this->evento = $evento;

        return $this;
    }


}
