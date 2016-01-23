<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 *
 * @ORM\Table(name="rechazo_archivo", indexes={@ORM\Index(name="detalle_orden", columns={"detalle_orden"})})
 * @ORM\Entity
 */
class RechazoArchivo {
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
     * @ORM\Column(name="archivo", type="string", length=255, nullable=true)
     */
    private $archivo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="motivo_archivo", type="string", length=500, nullable=false)
     */
    private $motivoArchivo;
    
    /**
     * @var \DetalleOrden
     *
     * @ORM\ManyToOne(targetEntity="DetalleOrden")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="detalle_orden", referencedColumnName="id")
     * })
     */
    private $detalleOrden;
    
    
    
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
     * Set archivo
     *
     * @param string $archivo
     *
     * @return RechazoArchivo
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }
    
    /**
     * Set motivoArchivo
     *
     * @param string $motivoArchivo
     *
     * @return RechazoArchivo
     */
    public function setMotivoArchivo($motivoArchivo)
    {
        $this->motivoArchivo = $motivoArchivo;

        return $this;
    }

    /**
     * Get motivoArchivo
     *
     * @return string
     */
    public function getMotivoArchivo()
    {
        return $this->motivoArchivo;
    }
    
    /**
     * Set detalleOrden
     *
     * @param \DG\ImpresionBundle\Entity\DetalleOrden $detalleOrden
     *
     * @return RechazoArchivo
     */
    public function setDetalleOrden(\DG\ImpresionBundle\Entity\DetalleOrden $detalleOrden = null)
    {
        $this->detalleOrden = $detalleOrden;

        return $this;
    }

    /**
     * Get detalleOrden
     *
     * @return \DG\ImpresionBundle\Entity\DetalleOrden
     */
    public function getDetalleOrden()
    {
        return $this->detalleOrden;
    } 
}
