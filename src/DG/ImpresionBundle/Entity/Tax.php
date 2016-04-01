<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cookie
 *
 * @ORM\Table(name="tax")
 * @ORM\Entity
 */
class Tax
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
     * @var float
     *
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=false)
     */
    private $valor;

    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    
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
     * Set valor
     *
     * @param float $valor
     *
     * @return Tax
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
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Tax
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
        return $this->valor;
    }
}
