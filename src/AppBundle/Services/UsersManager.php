<?php
/**
 * Created by PhpStorm.
 * User: yerow
 * Date: 17/05/2017
 * Time: 22:51
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use AppBundle\Form\Type\InscriptionType;
use AppBundle\Form\Type\UserManagerType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;

class UsersManager
{

    private $doctrine;
    private $form;
    private $session;
    private $mailer;
    private $securite;
    private $photoManager;


    public function __construct(
        EntityManager $doctrine,
        FormFactory $form,
        Session $session,
        Mailer $mailer,
        Securite $securite,
        PhotoManager $photoManager

    ){
        $this->doctrine = $doctrine;
        $this->form = $form;
        $this->session = $session;
        $this->mailer = $mailer;
        $this->securite = $securite;
        $this->photoManager = $photoManager;
    }


    //Récupére le formulaire correspondant à un membre précis pour la partie gestion des membres
    public function form(Request $request){

        $id = $request->get('id');
        $em = $this->doctrine;
        $user = $em->getRepository('AppBundle:User')->find($id);
        $obsValid = $em->getRepository('AppBundle:Observation')->getValidatedNbForUser($id);
        $form = $this->form->createNamed('user',UserManagerType::class,$user);
        $form->handleRequest($request);
         
        if($form->isSubmitted() && $form->isValid()){

            if ($form->getData()->getAccount() == 'Naturaliste'){
                $user->setRoles(array(User::NATURALISTE));
            }else{
                $user->setRoles(array(User::PARTICULIER));
            }

            $em->persist($user);
            $em->flush();

            $this->session->getFlashBag()->add('success', "Les modifications ont bien été réalisées");
            echo('  ');
            return null;
            
        }

        return array($form->createView(), $user, $obsValid);
    }



    //Récupere les utilisateurs dans le tableau gestion des membres
    public function getUsers(){

        return (new JsonResponse())->setData(array(
            'data' => $this->doctrine->getRepository('AppBundle:User')->getUsers()
            )
        );
    }


    //Récupére les statistiques à afficher dans la partie gestion des membres
    public function getDatas(){

        $nbNat = $this->doctrine->getRepository('AppBundle:User')->getNaturalisteNb();
        $nbPar = $this->doctrine->getRepository('AppBundle:User')->getParticulierNb();
        $nbNatW = 0;
        $nbObsAll = $this->doctrine->getRepository('AppBundle:Observation')->getAllNb();
        $nbObsWai = $this->doctrine->getRepository('AppBundle:Observation')->getWaitingNb();
        $nbObsVal =  $this->doctrine->getRepository('AppBundle:Observation')->getValidatedNb();

        return array($nbNat,$nbPar,$nbNatW,$nbObsAll,$nbObsWai,$nbObsVal);
    }


    //Action de suppression de d'un utilisateur
    public function deleteUser(Request $request){

        $em = $this->doctrine;
        $id = $request->request->get('id');
        if($user = $em->getRepository('AppBundle:User')->find($id)){
            $em->remove($user);
            $em->flush();
            $this->session->getFlashBag()->add('success', "Utilisateur supprimé");
            return new Response('deleted');
        }else{
            $this->session->getFlashBag()->add('error', "Erreur de suppression");
            return new Response('error');
        }

    }


    //Action de demande d'un autre justificatif
    public function anotherJustificatory(Request $request){

        $em = $this->doctrine;
        $id = $request->request->get('id');
        if($user = $em->getRepository('AppBundle:User')->find($id))
        {
            $user->setJustificatif(null);
            $em->flush();
            $this->mailer->sendNewJustificatoryMail($user);
            $this->session->getFlashBag()->add('success', "Demande de justificatif effectuée");
            return new Response('success');
        }else{
            $this->session->getFlashBag()->add('error', "Utilisateur non trouvé");
            return new Response('error');
        }

    }

    //Télecharge le justificatif du membre
    public function downloadJustificatory($justificatif){
        $justificatif = $this->doctrine->getRepository('AppBundle:Photo')->find($justificatif);
        $response = new BinaryFileResponse($this->photoManager->getWebPath($justificatif));
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }

    //Modifications des informations personnelles
    public  function modify(Request $request,User $user)
    {
        $originalPassword = $user->getPassword();
        $originalUsername = $user->getUsername();

        $em = $this->doctrine;
        $form = $this->form->createNamed('user',InscriptionType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            if ($form->getData()->getPassword()){
                $this->securite->cryptPassword($user, $form->getData()->getPassword());
                $this->session->getFlashBag()->add("info", "Votre mot de passe a été modifié, vous pouvez dès à présent utiliser votre nouveau mot de passe");
            }else{
                $user->setPassword($originalPassword);
            }

            if ($originalUsername != $user->getUsername()){
                $user->setValidMail(false);
                $this->mailer->sendChangeMail($user);

                $em->persist($user);
                $em->flush();

                $this->session->getFlashBag()->add("info", "Vous allez recevoir une demande de confirmation de votre nouvelle adresse mail");
                return 'logout';
            }

            $em->persist($user);
            $em->flush();

            $this->session->getFlashBag()->add('info', "Les modifications ont bien été réalisées");
            return null;
        } 

        return $form;
    }

}
