<?php 
// src/AppBundle/Services/Mailer.php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormFactory;

class Mailer
{

	private $mailer;
    private $twig;
    private $session;
    private $form;

    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $twig,
         Session $session,
        FormFactory $form)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->session = $session;
        $this->form = $form;
    }
    
    public function sendContact(Request $request) {

    	$form = $this->form->create(ContactType::class, null);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                    ->setSubject($data["objet"])
                    ->setFrom($data["email"])
                    ->setTo('contact.nao1@gmail.com')
                    ->setBody(
                                $this->twig->render(
                                    'email/email_contact.html.twig',
                                    array('nomcomplet' => $data["nomcomplet"],'message' => $data["message"], 'email' => $data["email"])
                                ),'text/html');

            $this->session->getFlashBag()
                 ->add('success', 'Votre message à été envoyé, vous recevrez une réponse dans les 48 heures');
            $this->mailer->send($message);

              return null;
        }

        return $form;
    }

    //Envoi mail de demande de nouveau justificatif
    public function sendNewJustificatoryMail(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setCharset('UTF-8')
            ->setSubject('Compte Naturaliste - Veuillez modifier votre justificatif')
            ->setBody($this->twig->render('email/email_ask_justificatory.html.twig', array(
                'id' => $user->getId(),
                'username' => $user->getUsername(),
            )))
            ->setContentType('text/html')
            ->setFrom('test@gmail.com')
            ->setTo($user->getUsername());

        $this->mailer->send($message);

    }

    //Envoi mail de changement de mail
    public function sendChangeMail(User $user)
    {

        if ($user) {
            $message = \Swift_Message::newInstance()
                ->setCharset('UTF-8')
                ->setSubject('Veuillez confirmer votre changement d\'email')
                ->setBody($this->twig->render('email/email_change_username.html.twig', array(
                    'id'            => $user->getId(),
                    'username'        => $user->getUsername(),
                    'code_validation' => $user->getCodeValidation(),
                )))
                ->setContentType('text/html')
                ->setFrom('test@gmail.com')
                ->setTo($user->getUsername());

            $this->mailer->send($message);
        }
    }

    //Email create account
    public function sendCreateAccountMail(User $user)
    {

        if ($user) {
            $message = \Swift_Message::newInstance()
                ->setCharset('UTF-8')
                ->setSubject('Veuillez confirmer votre inscription')
                ->setBody($this->twig->render('email/email_inscription.html.twig', array(
                    'id'            => $user->getId(),
                    'username'        => $user->getUsername(),
                    'code_validation' => $user->getCodeValidation(),
                )))
                ->setContentType('text/html')
                ->setFrom('test@gmail.com')
                ->setTo($user->getUsername());

            $this->mailer->send($message);
        }
    }

    //Email new password
    public function sendUpdatePasswordMail(User $user, $password)
    {
        $message = \Swift_Message::newInstance()
            ->setCharset('UTF-8')
            ->setSubject('Nouveau mot de passe')
            ->setBody($this->twig->render('email/email_new_password.html.twig', array(
                'id'            => $user->getId(),
                'username'        => $user->getUsername(),
                'password'          => $password
            )))
            ->setContentType('text/html')
            ->setFrom('test@gmail.com')
            ->setTo($user->getUsername());

        $this->mailer->send($message);
    }





}
