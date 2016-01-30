<?php

namespace DG\ImpresionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 *
 * @ORM\Table(name="direccion", indexes={@ORM\Index(name="usuario", columns={"usuario"})})
 * @ORM\Entity
 */
class Direccion 
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
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=25, nullable=true)
     */
    private $phoneNumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="linea_1", type="string", length=150, nullable=true)
     */
    private $linea1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="linea_2", type="string", length=150, nullable=true)
     */
    private $linea2;
    
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=150, nullable=true)
     */
    private $city;
    
    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=150, nullable=true)
     */
    private $state;
    
    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=100, nullable=true)
     */
    private $country;
    
    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=20, nullable=true)
     */
    private $zipCode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="security_access_code", type="string", length=255, nullable=true)
     */
    private $securityAccessCode;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="default_dir", type="boolean", nullable=false)
     */
    private $defaultDir;
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Direccion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Direccion
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    
    /**
     * Set linea1
     *
     * @param string $linea1
     *
     * @return Direccion
     */
    public function setLinea1($linea1)
    {
        $this->linea1 = $linea1;

        return $this;
    }

    /**
     * Get linea1
     *
     * @return string
     */
    public function getLinea1()
    {
        return $this->linea1;
    }
    
    /**
     * Set linea2
     *
     * @param string $linea2
     *
     * @return Direccion
     */
    public function setLinea2($linea2)
    {
        $this->linea2 = $linea2;

        return $this;
    }

    /**
     * Get linea2
     *
     * @return string
     */
    public function getLinea2()
    {
        return $this->linea2;
    }
    
    /**
     * Set city
     *
     * @param string $city
     *
     * @return Direccion
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Set state
     *
     * @param string $state
     *
     * @return Direccion
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Set country
     *
     * @param string $country
     *
     * @return Direccion
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Direccion
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    /**
     * Set securityAccessCode
     *
     * @param string $securityAccessCode
     *
     * @return Direccion
     */
    public function setSecurityAccessCode($securityAccessCode)
    {
        $this->securityAccessCode = $securityAccessCode;

        return $this;
    }

    /**
     * Get securityAccessCode
     *
     * @return string
     */
    public function getSecurityAccessCode()
    {
        return $this->securityAccessCode;
    }
    
    /**
     * Set defaultDir
     *
     * @param boolean $defaultDir
     *
     * @return Direccion
     */
    public function setDefaultDir($defaultDir)
    {
        $this->defaultDir = $defaultDir;

        return $this;
    }

    /**
     * Get defaultDir
     *
     * @return boolean
     */
    public function getDefaultDir()
    {
        return $this->defaultDir;
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
        return $this->linea1 ? $this->linea1.', '.$this->city.', '.$this->state.'.' : '';
    }
}
