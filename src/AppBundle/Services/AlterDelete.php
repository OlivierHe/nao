<?php 
// src/AppBundle/Services/AlterDelete.php
namespace AppBundle\Services;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Observation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlterDelete
{

	private $doctrine;


	public function __construct(EntityManager $doctrine) 
	{
		$this->doctrine = $doctrine;
	}

    // utilise l'id de l'observation et le pseudo de l'utilisateur pour supprimer une observation
	public function deleteObs(Request $request) 
	{
		$idObs = $request->query->get('idobs');
		$auteur = $request->query->get('auteur');
		$em = $this->doctrine;
		$observation = $em->getRepository('AppBundle:Observation')->find($idObs);
		$user = $em->getRepository('AppBundle:User')->findOneBy(array('pseudo' => $auteur));
		$user->removeObservation($observation);
		$em->flush();

		return new Response('deleted');
	}

    // permet de modifier le "state" d'une observation prend l'id de l'observation
	public function updateStatus(Request $request,User $user)
	{
    	$idObs = $request->query->get('idobs');
    	$idEspece = $request->query->get('idespece');
    	$state = $request->query->get('state');

    	$em = $this->doctrine;
		$observation = $em->getRepository('AppBundle:Observation')->find($idObs);
		$taxref = $em->getRepository('AppBundle:Taxref')->find($idEspece);
		if ($state ==='1') {
			$observation->setState(Observation::STATE_VALID);
		} elseif ($state ==='2') {
        	$observation->setState(Observation::STATE_REFUSED);   
		}
        $observation->setValidatedBy($user);
		$observation->setTaxref($taxref);
		$em->flush();
		return new Response('updated');
	}
}
