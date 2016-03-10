<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpcionProducto
 *
 * @ORM\Table(name="opcion_producto", indexes={@ORM\Index(name="categoria", columns={"categoria"})})
 * @ORM\Entity
 */
class OpcionProducto
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
     * @ORM\Column(name="costo", type="float", nullable=false)
     */
    private $costo;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * })
     */
    private $categoria;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set costo
     *
     * @param string $costo
     *
     * @return OpcionProducto
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return string
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set categoria
     *
     * @param \DG\ImpresionBundle\Entity\Categoria $categoria
     *
     * @return OpcionProducto
     */
    public function setCategoria(\DG\ImpresionBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \DG\ImpresionBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
    
    /**
     * Set detalleParametro
     *
     * @param \DG\ImpresionBundle\Entity\DetalleParametro $detalleParametro
     *
     * @return OpcionProducto
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
}
