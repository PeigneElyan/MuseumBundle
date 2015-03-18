<?php

namespace KE\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KE\MuseumBundle\Entity\EtageRepository")
 */
class Etage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="longueur", type="integer")
     */
    private $longueur;

    /**
     * @var integer
     *
     * @ORM\Column(name="profondeur", type="integer")
     */
    private $profondeur;

    /**
     * @var integer
     *
     * @ORM\Column(name="hauteur", type="integer")
     */
    private $hauteur;
	
	 /**
     * @var integer
     *
     * @ORM\Column(name="placeDisponible", type="integer")
     */
    private $placeDisponible;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="id_armoire", type="integer")
     */
    private $id_armoire;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre_armoire;

	/**
     * on Create
     *
     * @return Etage
     */
	public function onCreate(){
		$this->setPlaceDisponible($this->longueur);
		return $this;
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
     * Set code
     *
     * @param string $code
     * @return Etage
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
	
    /**
     * Set longueur
     *
     * @param integer $longueur
     * @return Etage
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
    
        return $this;
    }

    /**
     * Get longueur
     *
     * @return integer 
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * Set profondeur
     *
     * @param integer $profondeur
     * @return Etage
     */
    public function setProfondeur($profondeur)
    {
        $this->profondeur = $profondeur;
    
        return $this;
    }

    /**
     * Get profondeur
     *
     * @return integer 
     */
    public function getProfondeur()
    {
        return $this->profondeur;
    }

    /**
     * Set hauteur
     *
     * @param integer $hauteur
     * @return Etage
     */
    public function setHauteur($hauteur)
    {
        $this->hauteur = $hauteur;
    
        return $this;
    }

    /**
     * Get hauteur
     *
     * @return integer 
     */
    public function getHauteur()
    {
        return $this->hauteur;
    }
	
	/**
     * Set placeDisponible
     *
     * @param integer $placeDisponible
     * @return Etage
     */
    public function setPlaceDisponible($placeDisponible)
    {
        $this->placeDisponible = $placeDisponible;
    
        return $this;
    }
	
	/**
     * Get placeDisponible
     *
     * @return integer 
     */
    public function getPlaceDisponible()
    {
        return $this->placeDisponible;
    }
	
	
    /**
     * Set id_armoire
     *
     * @param integer $id_armoire
     * @return Etage
     */
    public function setIdArmoire($id_armoire)
    {
        $this->id_armoire = $id_armoire;
    
        return $this;
    }

    /**
     * Get id_armoire
     *
     * @return integer 
     */
    public function getIdArmoire()
    {
        return $this->id_armoire;
    }

    /**
     * Set ordre_armoire
     *
     * @param integer $ordre_armoire
     * @return Etage
     */
    public function setOrdreArmoire($ordre_armoire)
    {
        $this->ordre_armoire = $ordre_armoire;
    
        return $this;
    }

    /**
     * Get ordre_armoire
     *
     * @return integer 
     */
    public function getOrdreArmoire()
    {
        return $this->ordre_armoire;
    }
}
