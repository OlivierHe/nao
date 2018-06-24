<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ManageUserController extends Controller
{
    /**
     * @Route("/users_query", name="users_query")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function  usersQueryAction(){

        return $this->container->get('app.users_manager')->getUsers();
    }

    /**
     * @Route("/gestion_membres_delete", name="gestion_membres_delete")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteUserAction(Request $request)
    {
        return $this->container->get('app.users_manager')->deleteUser($request);
    }

    /**
     * @Route("/ask-another-justificatory", name="ask_another_justificatory")
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function askJustificatoryAction(Request $request)
    {
        return $this->container->get('app.users_manager')->anotherJustificatory($request);
    }

    /**
     * @Route("/download-justificatory/{justificatif}", name="download_justificatory")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function downloadJustificatoryAction($justificatif)
    {
        return $this->container->get('app.users_manager')->downloadJustificatory($justificatif);
    }

    /**
     * @Route("/gestion_membres", name="gestion_membres")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function gestionMembresAction()
    {

        $data = $this->container->get('app.users_manager')->getDatas();

        return $this->render(':back:gestion_membres.html.twig', array(
            "datas" => $data
        ));
    }

    /**
     * @Route("/gestion_membres_form", name="gestion_membres_form")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function getFormMemberManagerAction(Request $request)
    {

        $response = $this->container->get('app.users_manager')->form($request);

        if ($request->isMethod('POST') && $response === null){
             return $this->redirectToRoute('gestion_membres');
        }else {

            return $this->render(':back:gestion_membres_form.html.twig', array(
                'form' => $response[0],
                'user' => $response[1],
                'obsValid' => $response[2]
            ));
        }

    }

}
