<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Form\Type\InscriptionType;
use AppBundle\Form\Type\RecoveryPasswordType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class Securite
{


    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * @var FormFactory
     */
    private $form;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var PasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var
     */
    private $authentificationUtils;



    public function __construct(
        EntityManager $doctrine,
        Session $session,
        FormFactory $form,
        UserPasswordEncoder $passwordEncoder,
        Mailer $mailer,
        AuthenticationUtils $authenticationUtils,
        RouterInterface $router
    ) {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->form = $form;
        $this->passwordEncoder = $passwordEncoder;
        $this->mailer = $mailer;
        $this->authentificationUtils = $authenticationUtils;
        $this->router = $router;
    }

    public function getConnexion()
    {
        $authenticationUtils = $this->authentificationUtils;
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authentificationUtils->getLastUsername();

        return [$error, $lastUsername];
    }


    public function register(Request $request)
    {
        $inscription = new User();

        $form = $this->form->create(InscriptionType::class, $inscription);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $data = $form->getData();
            $inscription->setValidMail(false);
            $data->setRoles(array(User::EN_ATTENTE_DE_VALIDATION));
            $inscription->setAccount('Particulier');
            $inscription->setMember(false);


            $password = $inscription->getPassword();

            $this->cryptPassword($inscription, $password);

            $this->doctrine->persist($inscription);
            $this->doctrine->flush();
            $this->session->getFlashBag()->add("info", "Vous allez recevoir une demande de confirmation sur votre adresse email");

            $this->mailer->sendCreateAccountMail($inscription);
            
            return null;
        }
        return $form;
    }


    //Crypt password
    public function cryptPassword(User $user, $plainPassword)
    {
        $encoder = $this->passwordEncoder;

        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
    }



    //Verify for valid register
    public function validMail(Request $request)
    {
        $codeValidation = $request->attributes->get('code_validation');
        $idUser = $request->attributes->get('id');

        $em = $this->doctrine;

        $user = $em->getRepository('AppBundle:User')->findOneBy( array('id' => $idUser));

        if ($user) {
            $userValidation = $user->getCodeValidation();
            if ($userValidation === $codeValidation)
            {
                $user->setRoles(array(User::PARTICULIER));
                $user->setValidMail(true);
                $em->flush();

                return $this->session->getFlashBag()->add('success', "Votre compte est validé, vous pouvez vous connecter au site web");
            }
        }
        return $this->session->getFlashBag()->add('error', "Echec de la validation");

    }


    //Retrieve password
    public function recoverPassword(Request $request)
    {
        $form = $this->form->create(RecoveryPasswordType::class, null);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $data = $form->getData();
            $em = $this->doctrine;
            $checkUser = $em->getRepository('AppBundle:User')->findOneBy(array('username' => $data["username"]));

            if ($checkUser) {

                $dateSubmitted = $data["birthDate"];
                $userBirthDate = $checkUser->getBirthDate();

                // particularitée == et pas strict === sinon echec
                if ($userBirthDate == $dateSubmitted) {

                    $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz123456789"), 0, rand(5, 10));

                    $checkUser->setPassword($password);

                    $this->cryptPassword($checkUser, $password);

                    $em->flush();
                    $this->mailer->sendUpdatePasswordMail($checkUser, $password);
                    $this->session->getFlashBag()->add("info", "Vous allez recevoir un nouveau mot de passe dans votre boite email");

                    return null;
                }
            }
            $this->session->getFlashBag()->add("warning", "L’adresse email ou la date de naissance est erronée");
        }
        return $form;
    }




    public function landingPage(Request $request)
    {
        return $this->register($request);
    }

}
