<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;





class ApiController extends Controller
{

    /**
     * @Route("/taxref_query", name="taxref_query")
     * @Method({"GET"})
     */
    public function taxrefQueryAction(Request $request)
    {
        $rep = $this->get('app.generate_response')->getJson($request);
        return $rep;
    }

     /**
     * @Route("/observation_query", name="observation_query")
     * @Method({"GET"})
     */
    public function observationQueryAction(Request $request)
    {
        $rep = $this->get('app.generate_response')->getXml($request);
        return $rep;
    }

    /**
     * @Route("/observation_validee_query", name="observation_validee_query")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function observationValideeQueryAction()
    {
        $rep = $this->get('app.generate_response')->getObsValidee();
        return $rep;
    }

    /**
     * @Route("/observation_delete_query", name="observation_delete_query")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function observationDeleteQueryAction(Request $request)
    {
        $rep = $this->get('app.alter_delete')->deleteObs($request);
        return $rep;
    }

    /**
     * @Route("/observation_attente_query", name="observation_attente_query")
     * @Method({"GET"})
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function observationAttenteQueryAction()
    {
        $rep = $this->get('app.generate_response')->getObsAttente();
        return $rep;
    }

    /**
     * @Route("/observation_update_state_query", name="observation_update_state_query")
     * @Method({"GET"})
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function observationUpdateStateQueryAction(Request $request)
    {
        $rep = $this->get('app.alter_delete')->updateStatus($request,$this->getUser());
        return $rep;
    }

     /**
     * @Route("/observation_status_query", name="observation_status_query")
     * @Method({"GET"})
     * @Security("has_role('ROLE_PARTICULIER')")
     */
    public function observationStatusQueryAction()
    {
        $rep = $this->get('app.generate_response')->getStatuts($this->getUser());
        return $rep;
    }
}
