<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orden
 *
 * @ORM\Table(name="orden")
 * @ORM\Entity
 */
class Orden
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
     * @var string
     *
     * @ORM\Column(name="nombre_proyecto", type="string", length=150, nullable=false)
     */
    private $nombreProyecto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_orden", type="datetime", nullable=true)
     */
    private $fechaOrden;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=3, nullable=false)
     */
    private $estado;
    
    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \Direccion
     *
     * @ORM\ManyToOne(targetEntity="Direccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="direccion_envio", referencedColumnName="id")
     * })
     */
    private $direccionEnvio;
    
    /**
     * @var \Promocion
     *
     * @ORM\ManyToOne(targetEntity="Promocion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="promocion", referencedColumnName="id")
     * })
     */
    private $promocion;
    
    /**
     * @var \Persona
     *
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente", referencedColumnName="id")
     * })
     */
    private $cliente;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="DetalleOrden", mappedBy="orden", cascade={"persist", "remove"})
     */
    private $detalleOrden;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="id_pago", type="string", length=255, nullable=false)
     */
    private $idPago;
    
    
    /**
     * @var float
     *
     * @ORM\Column(name="reembolso", type="float", nullable=false)
     */
    private $reembolso;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="tarjeta_pago", type="string", length=20, nullable=false)
     */
    private $tarjetaPago;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="direccion_envio_guardar", type="string", length=1000, nullable=false)
     */
    private $direccionEnvioGuardar;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="datetime", nullable=true)
     */
    private $fechaPago;
    
    
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
     * Set nombreProyecto
     *
     * @param string $nombreProyecto
     *
     * @return Orden
     */
    public function setNombreProyecto($nombreProyecto)
    {
        $this->nombreProyecto = $nombreProyecto;

        return $this;
    }

    /**
     * Get nombreProyecto
     *
     * @return string
     */
    public function getNombreProyecto()
    {
        return $this->nombreProyecto;
    }

    /**
     * Set fechaOrden
     *
     * @param \DateTime $fechaOrden
     *
     * @return Orden
     */
    public function setFechaAccion($fechaOrden)
    {
        $this->fechaOrden = $fechaOrden;

        return $this;
    }

    /**
     * Get fechaOrden
     *
     * @return \DateTime
     */
    public function getFechaOrden()
    {
        return $this->fechaOrden;
    }
    
    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Orden
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    /**
     * Set usuario
     *
     * @param \DG\ImpresionBundle\Entity\Usuario $usuario
     *
     * @return Orden
     */
    public function setUsuario(\DG\ImpresionBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \DG\ImpresionBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    /**
     * Set direccionEnvio
     *
     * @param \DG\ImpresionBundle\Entity\Direccion $direccionEnvio
     *
     * @return Orden
     */
    public function setDireccionEnvio(\DG\ImpresionBundle\Entity\Direccion $direccionEnvio = null)
    {
        $this->direccionEnvio = $direccionEnvio;

        return $this;
    }

    /**
     * Get direccionEnvio
     *
     * @return \DG\ImpresionBundle\Entity\Direccion
     */
    public function getDireccionEnvio()
    {
        return $this->direccionEnvio;
    }
    
    /**
     * Set promocion
     *
     * @param \DG\ImpresionBundle\Entity\Promocion $promocion
     *
     * @return Orden
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
    
    /**
     * Set direccionEnvio
     *
     * @param \DG\ImpresionBundle\Entity\DetalleOrden $detalleOrden
     *
     * @return Orden
     */
    public function setDetalleOrden(\DG\ImpresionBundle\Entity\DetalleOrden $detalleOrden = null)
    {
        $this->detalleOrden = $detalleOrden;

        return $this;
    }

    /**
     * Get direccionEnvio
     *
     * @return \DG\ImpresionBundle\Entity\DetalleOrden
     */
    public function getDetalleOrden()
    {
        return $this->detalleOrden;
    }
    
    
    
    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Orden
     */
    public function setIdPago($idPago)
    {
        $this->idPago= $idPago;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getIdPago()
    {
        return $this->idPago;
    }
    
    
    
    
    /**
     * Set fechaPago
     *
     * @param \DateTime $fechaPago
     *
     * @return Orden
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago= $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return \DateTime
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }
    
    
    
    
    
    
    /**
     * Set estado
     *
     * @param string $direccionEnvioGuardar
     *
     * @return Orden
     */
    public function setDireccionEnvioGuardar($direccionEnvioGuardar)
    {
        $this->direccionEnvioGuardar = $direccionEnvioGuardar;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getDireccionEnvioGuardar()
    {
        return $this->direccionEnvioGuardar;
    }
    
    
    
    
    
    
    
    
    
    
    /**
     * Set estado
     *
     * @param string $tarjetaPago
     *
     * @return Orden
     */
    public function setTarjetaPago($tarjetaPago)
    {
        $this->tarjetaPago = $tarjetaPago;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getTarjetaPago()
    {
        return $this->tarjetaPago;
    }
    
     /**
     * Set persona
     *
     * @param \DG\ImpresionBundle\Entity\Persona $cliente
     *
     * @return Orden
     */
    public function setCliente(\DG\ImpresionBundle\Entity\Persona $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \DG\ImpresionBundle\Entity\Persona 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
    
    
    
    
    /**
     * Set reembolso
     *
     * @param float $reembolso
     *
     *
     */
    public function setReembolso($reembolso)
    {
        $this->reembolso= $reembolso;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getReembolso()
    {
        return $this->reembolso;
    }
    
}
