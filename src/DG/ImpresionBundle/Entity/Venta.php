<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table(name="venta", indexes={@ORM\Index(name="fk_venta_orden1_idx", columns={"orden_id"}), @ORM\Index(name="fk_venta_promocion1_idx", columns={"promocion_id"}), @ORM\Index(name="fk_venta_persona1_idx", columns={"persona_id"})})
 * @ORM\Entity
 */
class Venta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=false)
     */
    private $monto;

    /**
     * @var integer
     *
     * @ORM\Column(name="cliente_id", type="integer", nullable=false)
     */
    private $clienteId;

    /**
     * @var \Orden
     *
     * @ORM\ManyToOne(targetEntity="Orden")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orden_id", referencedColumnName="id")
     * })
     */
    private $orden;

    /**
     * @var \Persona
     *
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     * })
     */
    private $persona;

    /**
     * @var \Promocion
     *
     * @ORM\ManyToOne(targetEntity="Promocion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="promocion_id", referencedColumnName="id")
     * })
     */
    private $promocion;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Venta
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set monto
     *
     * @param float $monto
     *
     * @return Venta
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set clienteId
     *
     * @param integer $clienteId
     *
     * @return Venta
     */
    public function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;

        return $this;
    }

    /**
     * Get clienteId
     *
     * @return integer
     */
    public function getClienteId()
    {
        return $this->clienteId;
    }

    /**
     * Set orden
     *
     * @param \DG\ImpresionBundle\Entity\Orden $orden
     *
     * @return Venta
     */
    public function setOrden(\DG\ImpresionBundle\Entity\Orden $orden = null)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return \DG\ImpresionBundle\Entity\Orden
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set persona
     *
     * @param \DG\ImpresionBundle\Entity\Persona $persona
     *
     * @return Venta
     */
    public function setPersona(\DG\ImpresionBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \DG\ImpresionBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set promocion
     *
     * @param \DG\ImpresionBundle\Entity\Promocion $promocion
     *
     * @return Venta
     */
    public function setPromocion(\DG\ImpresionBundle\Entity\Promocion $promocion = null)
    {
        $this->promocion = $promocion;

        return $this;
    }

    /**
     * Get promocion
     *
     * @return \DG\ImpresionBundle\Entity\Promocion
     */
    public function getPromocion()
    {
        return $this->promocion;
    }
}
