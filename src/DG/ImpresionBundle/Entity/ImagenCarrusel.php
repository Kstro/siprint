<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ImagenCarrusel
 *
 * @ORM\Table(name="imagen_carrusel")
 * @ORM\Entity
 */
class ImagenCarrusel
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
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;
    
     /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    /**
     * @var \Carrusel
     *
     * @ORM\ManyToOne(targetEntity="Carrusel", inversedBy="placas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="carrusel", referencedColumnName="id")
     * })
     */
    private $carrusel;
    
 
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
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Imagencarrusel
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
     * Set carrusel
     *
     * @param DG\ImpresionBundle\Entity\Carrusel $carrusel
     *
     * @return ImagenCarrusel
     */
    public function setCarrusel(DG\ImpresionBundle\Entity\Carrusel $carrusel = null)
    {
        $this->carrusel = $carrusel;

        return $this;
    }

    /**
     * Get carrusel
     *
     * @return DG\ImpresionBundle\Entity\Carrusel
     */
    public function getCarrusel()
    {
        return $this->carrusel;
    }

}
