<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recordatorio
 *
 * @ORM\Table(name="recordatorio")
 * @ORM\Entity
 */
class Recordatorio
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
     * @var \DateTime
     *
     * @ORM\Column(name="proximafecha", type="date", nullable=false)
     */
    private $proximafecha;

    /**
     * @var int
     *
     * @ORM\Column(name="periodocantidad", type="integer", nullable=false)
     */
    private $periodocantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="periodounidad", type="string", length=50, nullable=false)
     */
    private $periodounidad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProximafecha(): ?\DateTimeInterface
    {
        return $this->proximafecha;
    }

    public function setProximafecha(\DateTimeInterface $proximafecha): self
    {
        $this->proximafecha = $proximafecha;

        return $this;
    }

    public function getPeriodocantidad(): ?int
    {
        return $this->periodocantidad;
    }

    public function setPeriodocantidad(int $periodocantidad): self
    {
        $this->periodocantidad = $periodocantidad;

        return $this;
    }

    public function getPeriodounidad(): ?string
    {
        return $this->periodounidad;
    }

    public function setPeriodounidad(string $periodounidad): self
    {
        $this->periodounidad = $periodounidad;

        return $this;
    }


}
