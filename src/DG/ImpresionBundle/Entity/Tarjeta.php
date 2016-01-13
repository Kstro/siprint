<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarjeta
 *
 * @ORM\Table(name="tarjeta", indexes={@ORM\Index(name="fk_tarjeta_usuario1_idx", columns={"usuario"})})
 * @ORM\Entity
 */
class Tarjeta {
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
     * @ORM\Column(name="numero", type="string", length=20, nullable=false)
     */
    private $numero;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cvc", type="string", length=4, nullable=false)
     */
    private $cvc;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiracion", type="date", nullable=false)
     */
    private $expiracion;
    
    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
     * })
     */
    private $usuario;
    
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Tarjeta
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tarjeta
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
     * Set cvc
     *
     * @param string $cvc
     *
     * @return Tarjeta
     */
    public function setCvc($cvc)
    {
        $this->cvc = $cvc;

        return $this;
    }

    /**
     * Get cvc
     *
     * @return string
     */
    public function getCvc()
    {
        return $this->cvc;
    }
    
    /**
     * Set expiracion
     *
     * @param \DateTime $expiracion
     *
     * @return Tarjeta
     */
    public function setExpiracion($expiracion)
    {
        $this->expiracion = $expiracion;

        return $this;
    }

    /**
     * Get expiracion
     *
     * @return \DateTime
     */
    public function getExpiracion()
    {
        return $this->expiracion;
    }
    
    /**
     * Set usuario
     *
     * @param \DG\ImpresionBundle\Entity\Usuario $usuario
     *
     * @return Direccion
     */
    public function setUsuario(\DG\ImpresionBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \DG\ImpresionBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function __toString() 
    {
        return $this->numero ? $this->nombre.' - '.$this->numero : '';
    }
}
