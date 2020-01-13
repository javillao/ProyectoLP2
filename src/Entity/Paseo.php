<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paseo
 *
 * @ORM\Table(name="paseo", indexes={@ORM\Index(name="evento", columns={"evento"})})
 * @ORM\Entity
 */
class Paseo
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
     * @ORM\Column(name="lugar", type="string", length=100, nullable=false)
     */
    private $lugar;

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

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function setLugar(string $lugar): self
    {
        $this->lugar = $lugar;

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
