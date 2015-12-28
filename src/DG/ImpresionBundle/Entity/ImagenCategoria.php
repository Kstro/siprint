<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImagenCategoria
 *
 * @ORM\Table(name="imagen_categoria", indexes={@ORM\Index(name="fk_imagen_categoria_categoria1_idx", columns={"categoria"})})
 * @ORM\Entity
 */
class ImagenCategoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idimagen_categoria", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idimagenCategoria;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
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
     * Get idimagenCategoria
     *
     * @return integer
     */
    public function getIdimagenCategoria()
    {
        return $this->idimagenCategoria;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ImagenCategoria
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
     * @return ImagenCategoria
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
}
