<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * AtributoProductoOrden
 *
 * @ORM\Table(name="atributo_producto_orden", indexes={@ORM\Index(name="detalle_orden", columns={"detalle_orden"}), @ORM\Index(name="detalle_parametro", columns={"detalle_parametro"})})
 * @ORM\Entity
 */
class AtributoProductoOrden
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
     * @var \DetalleParametro
     *
     * @ORM\ManyToOne(targetEntity="DetalleParametro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="detalle_parametro", referencedColumnName="id")
     * })
     */
    private $detalleParametro;

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
     * Set detalleParametro
     *
     * @param \DG\ImpresionBundle\Entity\DetalleParametro $detalleParametro
     *
     * @return AtributoProductoOrden
     */
    public function setDetalleParametro(\DG\ImpresionBundle\Entity\DetalleParametro $detalleParametro = null)
    {
        $this->detalleParametro = $detalleParametro;

        return $this;
    }

    /**
     * Get detalleParametro
     *
     * @return \DG\ImpresionBundle\Entity\DetalleParametro
     */
    public function getDetalleParametro()
    {
        return $this->detalleParametro;
    }

    /**
     * Set detalleOrden
     *
     * @param \DG\ImpresionBundle\Entity\DetalleOrden $detalleOrden
     *
     * @return AtributoProductoOrden
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
