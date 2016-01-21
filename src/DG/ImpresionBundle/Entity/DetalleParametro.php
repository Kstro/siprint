<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleParametro
 *
 * @ORM\Table(name="detalle_parametro", indexes={@ORM\Index(name="fk_detalle_parametro_parametro1_idx", columns={"parametro"}), @ORM\Index(name="fk_detalle_parametro_tipo_parametro1_idx", columns={"tipo_parametro"})})
 * @ORM\Entity
 */
class DetalleParametro
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
     * @var float
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=false)
     */
    private $valor;

    /**
     * @var \Parametro
     *
     * @ORM\ManyToOne(targetEntity="Parametro", inversedBy="coleccion", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parametro", referencedColumnName="id")
     * })
     */
    private $parametro;

    /**
     * @var \TipoParametro
     *
     * @ORM\ManyToOne(targetEntity="TipoParametro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_parametro", referencedColumnName="id")
     * })
     */
    private $tipoParametro;



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
     * @return DetalleParametro
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
     * Set valor
     *
     * @param float $valor
     *
     * @return DetalleParametro
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set parametro
     *
     * @param \DG\ImpresionBundle\Entity\Parametro $parametro
     *
     * @return DetalleParametro
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
     * Set tipoParametro
     *
     * @param \DG\ImpresionBundle\Entity\TipoParametro $tipoParametro
     *
     * @return DetalleParametro
     */
    public function setTipoParametro(\DG\ImpresionBundle\Entity\TipoParametro $tipoParametro = null)
    {
        $this->tipoParametro = $tipoParametro;

        return $this;
    }

    /**
     * Get tipoParametro
     *
     * @return \DG\ImpresionBundle\Entity\TipoParametro
     */
    public function getTipoParametro()
    {
        return $this->tipoParametro;
    }
    
    public function __toString() {
        return $this->nombre;
    }
}
