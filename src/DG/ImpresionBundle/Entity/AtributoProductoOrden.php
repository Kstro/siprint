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
     * @var \OpcionProducto
     *
     * @ORM\ManyToOne(targetEntity="OpcionProducto", inversedBy="atributProductOrden", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="opcion_producto", referencedColumnName="id")
     * })
     */
    private $opcionProducto;

    /**
     * @var \DetalleOrden
     *
     * @ORM\ManyToOne(targetEntity="DetalleOrden", inversedBy="atributoProductoOrden")
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
     * Set opcionProducto
     *
     * @param \DG\ImpresionBundle\Entity\OpcionProducto $opcionProducto
     *
     * @return AtributoProductoOrden
     */
    public function setOpcionProducto(\DG\ImpresionBundle\Entity\OpcionProducto $opcionProducto = null)
    {
        $this->opcionProducto = $opcionProducto;

        return $this;
    }

    /**
     * Get opcionProducto
     *
     * @return \DG\ImpresionBundle\Entity\OpcionProducto
     */
    public function getOpcionProducto()
    {
        return $this->opcionProducto;
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
