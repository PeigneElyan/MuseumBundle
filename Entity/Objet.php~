<?php

namespace KE\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objet
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KE\MuseumBundle\Entity\ObjetRepository")
 */
class Objet
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
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="Longueur", type="integer")
     */
    private $longueur;

    /**
     * @var integer
     *
     * @ORM\Column(name="Largeur", type="integer")
     */
    private $largeur;

    /**
     * @var integer
     *
     * @ORM\Column(name="Hauteur", type="integer")
     */
    private $hauteur;
	
	public function __construct()
  {
	$this->code         = null;
    $this->nom         = null;
    $this->longueur   = null;
    $this->largeur = null;
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
     * @return Objet
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
     * Set nom
     *
     * @param string $nom
     * @return Objet
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
	
	

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set longueur
     *
     * @param integer $longueur
     * @return Objet
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
     * Set largeur
     *
     * @param integer $largeur
     * @return Objet
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;

        return $this;
    }

    /**
     * Get largeur
     *
     * @return integer 
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * Set hauteur
     *
     * @param integer $hauteur
     * @return Objet
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
}
