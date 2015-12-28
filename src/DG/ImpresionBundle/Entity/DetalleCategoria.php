<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleCategoria
 *
 * @ORM\Table(name="detalle_categoria", indexes={@ORM\Index(name="fk_detalle_categoria_categoria1_idx", columns={"categoria"})})
 * @ORM\Entity
 */
class DetalleCategoria
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
     * @ORM\Column(name="nombre", type="string", length=200, nullable=false)
     */
    private $nombre;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Parametro", mappedBy="detalleCategoria")
     */
    private $parametro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parametro = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return DetalleCategoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set categoria
     *
     * @param \DG\ImpresionBundle\Entity\Categoria $categoria
     *
     * @return DetalleCategoria
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
     * Add parametro
     *
     * @param \DG\ImpresionBundle\Entity\Parametro $parametro
     *
     * @return DetalleCategoria
     */
    public function addParametro(\DG\ImpresionBundle\Entity\Parametro $parametro)
    {
        $this->parametro[] = $parametro;

        return $this;
    }

    /**
     * Remove parametro
     *
     * @param \DG\ImpresionBundle\Entity\Parametro $parametro
     */
    public function removeParametro(\DG\ImpresionBundle\Entity\Parametro $parametro)
    {
        $this->parametro->removeElement($parametro);
    }

    /**
     * Get parametro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParametro()
    {
        return $this->parametro;
    }
}
