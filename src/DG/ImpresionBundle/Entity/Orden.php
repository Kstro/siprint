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
     * @var string
     *
     * @ORM\Column(name="direccion_envio", type="string", length=255, nullable=false)
     */
    private $direccionEnvio;

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
     * Set direccionEnvio
     *
     * @param string $direccionEnvio
     *
     * @return Orden
     */
    public function setDireccionEnvio($direccionEnvio)
    {
        $this->direccionEnvio = $direccionEnvio;

        return $this;
    }

    /**
     * Get direccionEnvio
     *
     * @return string
     */
    public function getDireccionEnvio()
    {
        return $this->direccionEnvio;
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
}
