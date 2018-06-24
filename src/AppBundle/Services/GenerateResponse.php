<?php 
// src/AppBundle/Services/GenerateResponse.php
namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;


class GenerateResponse
{

	private $doctrine;
  private $serializer;

	public function __construct(EntityManager $doctrine,Serializer $serializer) 
	{
		$this->doctrine = $doctrine;
    $this->serializer = $serializer;
	}

  private function toForbidden()
  {
    // envoie erreur 403 accès refusé
    $response = new Response();
    $response->setStatusCode(Response::HTTP_FORBIDDEN);
    return $response;
  }

  private function toAccepted($rs, $type)
  {

    if ($type === 'json') {
      $response = new JsonResponse();
      $response->setData($rs);
    } else {
      $content = $this->serializer->serialize($rs,$type);
      $response = new Response();
      $response->setContent($content);
      $response->setStatusCode(Response::HTTP_OK);
      $header = 'application/' . $type;
      $response->headers->set('Content-Type', $header);
      // permet de d'obtenir un fichier pour le csv
      if ($type === 'csv') {
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'bdd.csv');
        $response->headers->set('Content-Disposition', $disposition);
      }
    }
    return $response;
  }

  public function getXml(Request $request) 
  {
  	$q = $request->query->get('q');
    $repository = $this->doctrine->getRepository('AppBundle:Observation');

    // vérifie que le param q est bien présent et que l'utilisateur n'envoie pas un string
    if (isset($q)) {
      if(intval($q)) { 
        $rs = $repository->getByIdTaxref($q);
        return $this->toAccepted($rs, 'xml');
      } elseif ($q === '') {
        $rs = $repository->getAll();
       return $this->toAccepted($rs, 'xml');
      } else {
        return $this->toForbidden();
      }
    } else {
        return $this->toForbidden();
    }


  }

  public function getJson(Request $request) 
  {

  $q = $request->query->get('q');
  $page = $request->query->get('page');


      // vérifie que le param page est existant et si il dépasse 15 résultat n'en afficher que 15
      if (isset($page)) {
        if($page != '0') {
            $page = intval($page);
            if ($page >= 15) {
              $page = 15;
            }
        }
       $rs = $this->doctrine->getRepository('AppBundle:Taxref')->showTaxref($q, $page);

        return $this->toAccepted($rs, 'json');
      } else {
          return $this->toForbidden();
          
      }

  }

  public function getObsValidee()
  {
    $rs = $this->doctrine->getRepository('AppBundle:Observation')->getObsValidee();
    return $this->toAccepted(array('data' => $rs), 'json');
  }

    public function getObsAttente()
  {
    $rs = $this->doctrine->getRepository('AppBundle:Observation')->getObsAttente();
    return $this->toAccepted(array('data' => $rs), 'json');
  }

  public function getStatuts(User $user)
  {
    $rs = $this->doctrine->getRepository('AppBundle:Observation')->getStatuts($user->getId());
    return $this->toAccepted(array('data' => $rs), 'json');
  }

  public function getCsv()
  {
    $rs = $this->doctrine->getRepository('AppBundle:Observation')->getObsExport();
    return $this->toAccepted($rs, 'csv');
  }

}

?>
