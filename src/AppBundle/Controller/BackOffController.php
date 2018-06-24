<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;




class BackOffController extends Controller
{

    /**
     * @Route("/ajouter_observation", name="ajouter_observation")
     * @Method({"GET","POST"})
     * @Security("has_role('ROLE_PARTICULIER')")
     */
    public function ajouterObservationAction(Request $request)
    {
        $form = $this->get('app.add_observation')->getForm($request);

        if ($request->isMethod('POST') && $form === null) {
            return $this->redirectToRoute('ajouter_observation');
        } else {
            return $this->render(':enfant:ajouter_observation.html.twig', array( 'form' => $form->createView()));
        }
    }


    // Back-End

    /**
     * @Route("/admin")
     * @Method({"GET"})
     */
    public function adminAction()
    {
        return $this->render(':back:admin.html.twig');
    }




    /**
     * @ROUTE("/mes_observations", name="mes_observations")
     * @Method({"GET"})
     * @Security("has_role('ROLE_PARTICULIER')")
     */
    public function mesObservationsAction()
    {
        return $this->render(':back:mes_observations.html.twig');
    }

    /**
     * @ROUTE("/observations_validees", name="observations_validees")
     * @Method({"GET"})
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function observationsValideesAction()
    {
        return $this->render(':back:observations_validees.html.twig');
    }

    /**
     * @Route("/update_account", name="update_account")
     * @Method({"GET","POST"})
     * @Security("has_role('ROLE_PARTICULIER')")
     */
    public function modificationsInfosAction(Request $request)
    {
        $form = $this->container->get('app.users_manager')->modify($request,$this->getUser());
        
        if ($request->isMethod('POST') && $form === null) {
            return $this->redirectToRoute('update_account');
        } elseif ($request->isMethod('POST') && $form === 'logout') {
            return $this->redirectToRoute('logout');
        }else{
            return $this->render(':back:update_account.html.twig',array('form' => $form->createView()));
        }

        
    }



    /**
     * @ROUTE("/validations_attentes", name="validations_attentes")
     * @Method({"GET"})
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function validationsAttenteAction()
    {
        return $this->render(':back:validations_attentes.html.twig');
    }


     /**
     * @Route("/exportation_bdd", name="exportation_bdd")
     * @Method({"GET"})
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function exportationBddAction()
    {
        $rep = $this->get('app.generate_response')->getCsv();
        return $rep;
    }

}
