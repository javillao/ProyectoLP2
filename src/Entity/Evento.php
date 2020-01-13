<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evento
 *
 * @ORM\Table(name="evento", indexes={@ORM\Index(name="mascota", columns={"mascota"}), @ORM\Index(name="recordatorio", columns={"recordatorio"})})
 * @ORM\Entity
 */
class Evento
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
     * @ORM\Column(name="estado", type="string", length=50, nullable=false)
     */
    private $estado;

    /**
     * @var \Mascota
     *
     * @ORM\ManyToOne(targetEntity="Mascota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mascota", referencedColumnName="id")
     * })
     */
    private $mascota;

    /**
     * @var \Recordatorio
     *
     * @ORM\ManyToOne(targetEntity="Recordatorio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recordatorio", referencedColumnName="id")
     * })
     */
    private $recordatorio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getMascota(): ?Mascota
    {
        return $this->mascota;
    }

    public function setMascota(?Mascota $mascota): self
    {
        $this->mascota = $mascota;

        return $this;
    }

    public function getRecordatorio(): ?Recordatorio
    {
        return $this->recordatorio;
    }

    public function setRecordatorio(?Recordatorio $recordatorio): self
    {
        $this->recordatorio = $recordatorio;

        return $this;
    }


}
