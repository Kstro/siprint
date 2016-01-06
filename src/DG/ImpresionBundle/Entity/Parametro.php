<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parametro
 *
 * @ORM\Table(name="parametro", indexes={@ORM\Index(name="fk_parametro_tipo_parametro1_idx", columns={"tipo_categoria"}), @ORM\Index(name="fk_parametro_parametro1_idx", columns={"parametro"})})
 * @ORM\Entity
 */
class Parametro
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
     * @var \Parametro
     *
     * @ORM\ManyToOne(targetEntity="Parametro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parametro", referencedColumnName="id")
     * })
     */
    private $parametro;

    /**
     * @var \TipoCategoria
     *
     * @ORM\ManyToOne(targetEntity="TipoCategoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_categoria", referencedColumnName="id")
     * })
     */
    private $tipoCategoria;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Categoria", mappedBy="parametro")
     */
    private $categoria;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DetalleCategoria", inversedBy="parametro")
     * @ORM\JoinTable(name="detalle_categoria_parametro",
     *   joinColumns={
     *     @ORM\JoinColumn(name="parametro_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="detalle_categoria_id", referencedColumnName="id")
     *   }
     * )
     */
    private $detalleCategoria;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="FormatoPlantilla", inversedBy="parametro")
     * @ORM\JoinTable(name="parametro_formato_plantilla",
     *   joinColumns={
     *     @ORM\JoinColumn(name="parametro", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="formato_plantilla", referencedColumnName="id")
     *   }
     * )
     */
    private $formatoPlantilla;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="DetalleParametro", mappedBy="parametro", cascade={"persist", "remove"})
     */
    private $coleccion;

    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->detalleCategoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->formatoPlantilla = new \Doctrine\Common\Collections\ArrayCollection();
        $this->coleccion = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getColeccion()
    {
        return $this->coleccion;
    }
    
    public function setColeccion(\Doctrine\Common\Collections\Collection $coleccion)
    {
        $this->coleccion = $coleccion;
        foreach ($coleccion as $detalle) {
            $detalle->setParametro($this);
        }
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
     * @return Parametro
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
     * Set parametro
     *
     * @param \DG\ImpresionBundle\Entity\Parametro $parametro
     *
     * @return Parametro
     */
    public function setParametro(\DG\ImpresionBundle\Entity\Parametro $parametro = null)
    {
        $this->parametro = $parametro;

        return $this;
    }

    /**
     * Get parametro
     *
     * @return \DG\ImpresionBundle\Entity\Parametro
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set tipoCategoria
     *
     * @param \DG\ImpresionBundle\Entity\TipoCategoria $tipoCategoria
     *
     * @return Parametro
     */
    public function setTipoCategoria(\DG\ImpresionBundle\Entity\TipoCategoria $tipoCategoria = null)
    {
        $this->tipoCategoria = $tipoCategoria;

        return $this;
    }

    /**
     * Get tipoCategoria
     *
     * @return \DG\ImpresionBundle\Entity\TipoCategoria
     */
    public function getTipoCategoria()
    {
        return $this->tipoCategoria;
    }

    /**
     * Add categorium
     *
     * @param \DG\ImpresionBundle\Entity\Categoria $categorium
     *
     * @return Parametro
     */
    public function addCategorium(\DG\ImpresionBundle\Entity\Categoria $categorium)
    {
        $this->categoria[] = $categorium;

        return $this;
    }

    /**
     * Remove categorium
     *
     * @param \DG\ImpresionBundle\Entity\Categoria $categorium
     */
    public function removeCategorium(\DG\ImpresionBundle\Entity\Categoria $categorium)
    {
        $this->categoria->removeElement($categorium);
    }

    /**
     * Get categoria
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add detalleCategorium
     *
     * @param \DG\ImpresionBundle\Entity\DetalleCategoria $detalleCategorium
     *
     * @return Parametro
     */
    public function addDetalleCategorium(\DG\ImpresionBundle\Entity\DetalleCategoria $detalleCategorium)
    {
        $this->detalleCategoria[] = $detalleCategorium;

        return $this;
    }

    /**
     * Remove detalleCategorium
     *
     * @param \DG\ImpresionBundle\Entity\DetalleCategoria $detalleCategorium
     */
    public function removeDetalleCategorium(\DG\ImpresionBundle\Entity\DetalleCategoria $detalleCategorium)
    {
        $this->detalleCategoria->removeElement($detalleCategorium);
    }

    /**
     * Get detalleCategoria
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalleCategoria()
    {
        return $this->detalleCategoria;
    }

    /**
     * Add formatoPlantilla
     *
     * @param \DG\ImpresionBundle\Entity\FormatoPlantilla $formatoPlantilla
     *
     * @return Parametro
     */
    public function addFormatoPlantilla(\DG\ImpresionBundle\Entity\FormatoPlantilla $formatoPlantilla)
    {
        $this->formatoPlantilla[] = $formatoPlantilla;

        return $this;
    }

    /**
     * Remove formatoPlantilla
     *
     * @param \DG\ImpresionBundle\Entity\FormatoPlantilla $formatoPlantilla
     */
    public function removeFormatoPlantilla(\DG\ImpresionBundle\Entity\FormatoPlantilla $formatoPlantilla)
    {
        $this->formatoPlantilla->removeElement($formatoPlantilla);
    }

    /**
     * Get formatoPlantilla
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormatoPlantilla()
    {
        return $this->formatoPlantilla;
    }
    
    public function __toString() {
        return $this->getNombre();
    }
    
    
    function getPaciente() {
        return $this->paciente;
    }

    function setPaciente($paciente) {
        $this->paciente = $paciente;
    }
}
