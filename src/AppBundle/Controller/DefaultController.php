<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;




class DefaultController extends Controller
{

    /**
     * @Route("/" , name="accueil")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render(':enfant:index.html.twig');
    }

    /**
     * @Route("/carte_interactive" , name="carte_interactive")
     * @Method({"GET"})
     */
    public function carteInteractiveAction()
    {
        return $this->render(':enfant:carte_interactive.html.twig');
    }

    /**
     * @Route("/notre_association" , name="notre_association")
     * @Method({"GET"})
     */
    public function notreAssociationAction()
    {
        return $this->render(':enfant:notre_association.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $request)
    {
        $form = $this->get("app.mailer")->sendContact($request);

        if ($request->isMethod('POST') && $form === null) {
            return $this->redirectToRoute('accueil');
        } else {
            return $this->render(':enfant:contact.html.twig', array(
            'form' => $form->createView()
            ));
        }

      
    }

    /**
     * @Route("/mentions_legales" , name="mentions_legales")
     * @Method({"GET"})
     */
    public function mentionsLegalesAction()
    {
        return $this->render(':enfant:mentions_legales.html.twig');
    }


    /**
     * @Route("/landing_page", name="landing_page")
     * @Method({"GET","POST"})
     */
    public function landingPageAction(Request $request)
    {
        $form = $this->get('app.securite')->landingPage($request);

        if ($request->isMethod('POST') && $form === null) {
            return $this->redirectToRoute('accueil');
        } else {
            return $this->render('enfant/landing_page.html.twig', array(
            'form' => $form->createView(),
            ));
        }

     
    }

}
