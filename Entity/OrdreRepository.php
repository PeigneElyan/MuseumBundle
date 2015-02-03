<?php

namespace KE\MuseumBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OrdreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdreRepository extends EntityRepository
{

	public function getNb($idEtage) {
 
        return $this->createQueryBuilder('o')
                    ->select('COUNT(o)')
					->where('o.idEtage = :idEtage')
					->setParameter('idEtage',$idEtage)
					->getQuery()
                    ->getSingleScalarResult();
 
    }

}
