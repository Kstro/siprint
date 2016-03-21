<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria", indexes={@ORM\Index(name="fk_categoria_categoria_idx", columns={"categoria"})})
 * @ORM\Entity
 */
class Categoria
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=1200, nullable=true)
     */
    private $descripcion;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;
    
    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

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
     * @ORM\ManyToMany(targetEntity="Parametro", inversedBy="categoria")
     * @ORM\JoinTable(name="categoria_parametro",
     *   joinColumns={
     *     @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="parametro_id", referencedColumnName="id")
     *   }
     * )
     */
    private $parametro;

    
    /**
     * @ORM\OneToMany(targetEntity="CategoriaProducto", mappedBy="categoria", cascade={"persist", "remove"})
     */
//    private $categoriaproducto;
    
    
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
     * @return Categoria
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Categoria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set categoria
     *
     * @param \DG\ImpresionBundle\Entity\Categoria $categoria
     *
     * @return Categoria
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
     * @return Categoria
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
    
    /**
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Categoria
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Categoria
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function __toString()
    {
        return $this->getNombre();
    }
    
//    function getCategoriaProducto() {
//        return $this->categoriaproducto;
//    }
//
//    function setCategoriaProducto(\DG\ImpresionBundle\Entity\CategoriaProducto $categoriaproducto = null) {
//        $this->categoriaproducto= $categoriaproducto;
//    }
    
}
