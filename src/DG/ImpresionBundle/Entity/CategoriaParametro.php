<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoriaParametro
 *
 * @ORM\Table(name="categoria_parametro", indexes={@ORM\Index(name="categoria", columns={"categoria"})})
 * @ORM\Entity
 */
class CategoriaParametro
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
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria", referencedColumnName="id")
     * })
     */
    private $categoria;

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
     * @return CategoriaParametro
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
     * Set parametro
     *
     * @param \DG\ImpresionBundle\Entity\Parametro $parametro
     *
     * @return CategoriaParametro
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
}
