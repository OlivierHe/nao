<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Observation;

/**
 * ObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
	public function getAll() {
		// select * from observation where DATEDIFF(NOW(),date) >= 5 AND validated_by_id IS NOT NULL
		   $query = $this->_em->createQuery('SELECT o.longitude, o.latitude, CONCAT(CONCAT(p.id, \'.\'),p.extension) As photo,
		   									t.nomRef, t.nomVern, u.pseudo, o.observationDate, t.cdNom
		  									FROM AppBundle:Observation o
		  									LEFT JOIN AppBundle:Photo p WITH o.photo = p.id
		  									LEFT JOIN AppBundle:Taxref t WITH o.taxref = t.id
		  									LEFT JOIN AppBundle:User u WITH o.author = u.id
		  									WHERE DATE_DIFF(CURRENT_TIMESTAMP(),o.date) >= 5 AND o.state = \'Validé\'
		  								  ');

		  $results = $query->getResult();

		  return $results;
	}

    public function getByIdTaxref($id) {
		   $query = $this->_em->createQuery('SELECT o.longitude, o.latitude, CONCAT(CONCAT(p.id, \'.\'),p.extension) As photo,
		   									t.nomRef, t.nomVern, u.pseudo, o.observationDate, t.cdNom
		  									FROM AppBundle:Observation o
		  									LEFT JOIN AppBundle:Photo p WITH o.photo = p.id
		  									LEFT JOIN AppBundle:Taxref t WITH o.taxref = t.id
		  									LEFT JOIN AppBundle:User u WITH o.author = u.id
		  									WHERE o.taxref = :id
		  									AND DATE_DIFF(CURRENT_TIMESTAMP(),o.date) >= 5 
		  									AND o.state = \'Validé\'
		  								  ')->setParameter('id', $id);

		  $results = $query->getResult();

		  return $results;
	}

	public function getAllNb(){
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getValidatedNb(){
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.state = :x')
            ->setParameter('x', Observation::STATE_VALID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getValidatedNbForUser($id){
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.author = :s')
            ->setParameter('s', $id)
            ->andWhere('a.state = :x')
            ->setParameter('x', Observation::STATE_VALID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getWaitingNb(){
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.state = :x')
            ->setParameter('x', Observation::STATE_WAITING)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getObsValidee() {
		   $query = $this->_em->createQuery('SELECT o.observationDate As date,  
		   									CONCAT(CONCAT(t.nomRef, \'.\'),t.nomVern) As especes, 
		   									CONCAT(CONCAT(o.latitude, \',\'),o.longitude) As latlong, 
		   									u.pseudo As auteur,
		   									z.pseudo As naturaliste,
		   									u.member As adherent,
		   									CONCAT(CONCAT(p.id, \'.\'),p.extension) As photo,
		   									o.id As idobs
		  									FROM AppBundle:Observation o
		  									LEFT JOIN AppBundle:Photo p WITH o.photo = p.id
		  									LEFT JOIN AppBundle:Taxref t WITH o.taxref = t.id
		  									LEFT JOIN AppBundle:User u WITH o.author = u.id
		  									LEFT JOIN AppBundle:User z WITH o.validatedBy = z.id
		  									WHERE o.state = \'Validé\'
		  								  ');

		  $results = $query->getResult();

		  return $results;
	}

	public function getObsAttente() {
		   $query = $this->_em->createQuery('SELECT o.observationDate As date, 
		   									t.id As idespece,
		   									CONCAT(CONCAT(t.nomRef, \'.\'),t.nomVern) As especes, 
		   									CONCAT(CONCAT(o.latitude, \',\'),o.longitude) As latlong, 
		   									CONCAT(CONCAT(p.id, \'.\'),p.extension) As photo,
		   									o.id As idobs
		  									FROM AppBundle:Observation o
		  									LEFT JOIN AppBundle:Photo p WITH o.photo = p.id
		  									LEFT JOIN AppBundle:Taxref t WITH o.taxref = t.id
		  									WHERE o.state = \'En attente\'
		  								  ');

		  $results = $query->getResult();

		  return $results;
	}

		public function getStatuts($userId) {
		   $query = $this->_em->createQuery('SELECT o.observationDate As date, 
		   									CONCAT(CONCAT(t.nomRef, \'.\'),t.nomVern) As especes, 
		   									CONCAT(CONCAT(o.latitude, \',\'),o.longitude) As latlong, 
		   									o.state As status,
		   									CONCAT(CONCAT(p.id, \'.\'),p.extension) As photo
		  									FROM AppBundle:Observation o
		  									LEFT JOIN AppBundle:Photo p WITH o.photo = p.id
		  									LEFT JOIN AppBundle:Taxref t WITH o.taxref = t.id
		  									LEFT JOIN AppBundle:User u WITH o.author = u.id
		  									WHERE o.author = :userId
		  								  ')->setParameter('userId', $userId);

		  $results = $query->getResult();

		  return $results;
	}


	public function getObsExport() {
		   $query = $this->_em->createQuery('SELECT o.longitude, o.latitude,
		   									t.nomRef, t.nomVern, o.observationDate, t.cdNom
		  									FROM AppBundle:Observation o
		  									LEFT JOIN AppBundle:Taxref t WITH o.taxref = t.id
		  									LEFT JOIN AppBundle:User u WITH o.author = u.id
		  								  ');

		  $results = $query->getResult();

		  return $results;
	}

}
