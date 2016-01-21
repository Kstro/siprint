<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=255, nullable=true)
     */
    private $archivo;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=false)
     */
    private $monto;
    
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
     * @ORM\ManyToOne(targetEntity="Orden",inversedBy="detalleOrden")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="orden", referencedColumnName="id")
     * })
     */
    private $orden;

    
    /**
     *
     * @ORM\OneToMany(targetEntity="AtributoProductoOrden", mappedBy="detalleOrden", cascade={"persist", "remove"})
     */
    private $atributoProductoOrden;


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
    
    /**
     * Set archivo
     *
     * @param string $archivo
     *
     * @return DetalleOrden
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
     * Set monto
     *
     * @param float $monto
     *
     * @return DetalleOrden
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }
    
    
    
    /**
     * Set atributoProductoOrden
     *
     * @param \DG\ImpresionBundle\Entity\AtributoProductoOrden $atributoProductoOrden
     *
     * @return Orden
     */
    public function setAtributoProductoOrden(\DG\ImpresionBundle\Entity\AtributoProductoOrden $atributoProductoOrden = null)
    {
        $this->atributoProductoOrden = $atributoProductoOrden;

        return $this;
    }

    /**
     * Get direccionEnvio
     *
     * @return \DG\ImpresionBundle\Entity\AtributoProductoOrden
     */
    public function getAtributoProductoOrden()
    {
        return $this->atributoProductoOrden;
    }
    
}
