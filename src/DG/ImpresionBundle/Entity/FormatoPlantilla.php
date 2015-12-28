<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormatoPlantilla
 *
 * @ORM\Table(name="formato_plantilla")
 * @ORM\Entity
 */
class FormatoPlantilla
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
     * @ORM\Column(name="nombre", type="string", length=75, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=false)
     */
    private $imagen;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Parametro", mappedBy="formatoPlantilla")
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
     * @return FormatoPlantilla
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
     * Set imagen
     *
     * @param string $imagen
     *
     * @return FormatoPlantilla
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return FormatoPlantilla
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

    /**
     * Add parametro
     *
     * @param \DG\ImpresionBundle\Entity\Parametro $parametro
     *
     * @return FormatoPlantilla
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
