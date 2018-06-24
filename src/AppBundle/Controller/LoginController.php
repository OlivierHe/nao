<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


class LoginController extends Controller
{

    /**
     * @Route("/inscription", name="inscription")
     * @Method({"GET","POST"})
     */
    public function inscriptionAction(Request $request)
    {
        $form = $this->get("app.securite")->register($request);

        if ($request->isMethod('POST') && $form === null) {
            return $this->redirectToRoute('connexion');
        } else {
            return $this->render(':enfant:inscription.html.twig', array(
            'form' => $form->createView(),
            ));
        }

     
    }

    /**
     * @Route("/connexion", name="connexion")
     * @Method({"GET","POST"})
     */
    public function connexionAction(Request $request)
    {
         $data = $this->get("app.securite")->getConnexion();

        if ($request->isMethod('POST')) {
            return $this->redirectToRoute('carte_interactive');
        } else {
            return $this->render(':enfant:connexion.html.twig', array(
                'last_username' => $data[1],
                'error' => $data[0],
            ));
        }

    }

    /**
     * @Route ("/recover_password", name ="recover_password")
     * @Method({"GET","POST"})
     */
    public function recoverPasswordAction(Request $request)
    {
        $form = $this->get("app.securite")->recoverPassword($request);

         if ($request->isMethod('POST') && $form === null) {
            return $this->redirectToRoute('connexion');
        }
        else {
            return $this->render(':enfant:recover_password.html.twig', array(
            'form' => $form->createView()
            ));
        }
    }

    /**
     * @Route ("/valid_mail/{id}/{code_validation}", name ="valid_mail")
     * @Method({"GET"})
     */
    public function validMailAction(Request $request)
    {
        $result = $this->get("app.securite")->validMail($request);

        return $this->render(':back:valid_mail.html.twig', array(
            'result' => $result,
    ));

    }


}
