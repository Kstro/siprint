<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleOrden
 *
 * @ORM\Table(name="detalle_orden", indexes={@ORM\Index(name="fk_detalle_orden_orden1_idx", columns={"orden"}), @ORM\Index(name="fk_detalle_orden_categoria1_idx", columns={"categoria"})})
 * @ORM\Entity
 */
class DetalleOrden
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
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     * @var \Orden
     *
     * @ORM\ManyToOne(targetEntity="Orden")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orden", referencedColumnName="id")
     * })
     */
    private $orden;



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
     * Set categoria
     *
     * @param \DG\ImpresionBundle\Entity\Categoria $categoria
     *
     * @return DetalleOrden
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
     * Set orden
     *
     * @param \DG\ImpresionBundle\Entity\Orden $orden
     *
     * @return DetalleOrden
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
}
