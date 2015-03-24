<?php

namespace KE\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Armoire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KE\MuseumBundle\Entity\ArmoireRepository")
 */
class Armoire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	**/ 
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Code", type="string", length=255)
     */
    private $code;


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
     * @return Armoire
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
	
	public function __toString()
	{
		return (string) $this->getCode();
	}

    /**
     * Set id
     *
     * @param integer $id
     * @return Armoire
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }
	
	public function countExisting($code)
    {
         $manager = $this->getEntityManager();

		/** @var Doctrine\ORM\Query $query */
		$query = $manager->
        createQuery('SELECT 1 FROM MuseumBundle:Armoire m WHERE m.code= :code')
            ->setParameter('code', $code)
            ->setMaxResults(1)
		;

		return (count($query->getResult()) == 0);
    }
}
