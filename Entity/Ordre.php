<?php

namespace KE\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ordre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KE\MuseumBundle\Entity\OrdreRepository")
 */
class Ordre
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
     * @var integer
     *
     * @ORM\Column(name="id_objet", type="integer")
     */
    private $idObjet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_etage", type="integer", nullable = true)
     */
    private $idEtage;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer", nullable = true)
     */
    private $ordre;
	
	/**
     * @var float
     *
     * @ORM\Column(name="pourcent", type="integer", nullable = true)
     */
    private $pourcent;

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
     * Set idObjet
     *
     * @param integer $idObjet
     * @return Ordre
     */
    public function setIdObjet($idObjet)
    {
        $this->idObjet = $idObjet;
    
        return $this;
    }

    /**
     * Get idObjet
     *
     * @return integer 
     */
    public function getIdObjet()
    {
        return $this->idObjet;
    }

    /**
     * Set idEtage
     *
     * @param integer $idEtage
     * @return Ordre
     */
    public function setIdEtage($idEtage)
    {
        $this->idEtage = $idEtage;
    
        return $this;
    }

    /**
     * Get idEtage
     *
     * @return integer 
     */
    public function getIdEtage()
    {
        return $this->idEtage;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     * @return Ordre
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    
        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }
	
	/**
     * Incrementer ordre
     *
     */
    public function incrementerOrdre()
    {
        $ordre = $ordre + 1;
    }
	/**
     * Decrementer ordre
     *
     */
    public function decrementerOrdre()
    {
		$ordre = $ordre - 1;
    }
	
	/**
     * cmp obj
     *
     */
	 static function cmp_obj($a, $b)
    {
        $al = $a->getOrdre();
        $bl = $b->getOrdre();
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }
	
<<<<<<< HEAD
     /* Set pourcent
=======
    /* Set pourcent
>>>>>>> 319bdf4e051c27d1a683040cc614f42bb4e5691e
     *
     * @param float $pourcent
     * @return Pourcent
     */
    public function setPourcent($pourcent)
    {
        $this->pourcent = $pourcent;
    
        return $this;
    }

    /**
     * Get pourcent
     *
     * @return float 
     */
    public function getPourcent()
    {
        return $this->pourcent;
    }
}
