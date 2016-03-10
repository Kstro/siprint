<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suscripcion
 *
 * @ORM\Table(name="suscripcion")
 * @ORM\Entity
 */
class Suscripcion
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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", length=255, nullable=false)
     */
    private $tema;
    
    /**
     * @var string
     *
     * @ORM\Column(name="correo_electronico", type="string", length=200, nullable=false)
     */
    private $correoElectronico;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mensaje", type="string", length=750, nullable=false)
     */
    private $mensaje;


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
     * @return Suscripcion
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
     * Set tema
     *
     * @param string $tema
     *
     * @return Suscripcion
     */
    public function setTema($tema)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return string
     */
    public function getTema()
    {
        return $this->tema;
    }
    
    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Suscripcion
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }
    
    /**
     * Set mensaje
     *
     * @param string $mensaje
     *
     * @return Suscripcion
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
}
