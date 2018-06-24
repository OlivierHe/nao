<?php
// src/AppBundle/Services/AddObservation.php
namespace AppBundle\Services;

use AppBundle\Entity\Observation;
use AppBundle\Form\Type\ObservationType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class AddObservation
{

    private $doctrine;
    private $form;
    private $session;
    private $storage;
    private $securityChecker;


    public function __construct(EntityManager $doctrine, Session $session, FormFactory $form, TokenStorageInterface $storage, AuthorizationCheckerInterface $securityChecker )
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->form = $form;
        $this->storage = $storage;
        $this->securityChecker = $securityChecker;

    }

    public function getForm(Request $request)
    {
        $em = $this->doctrine;
        $observation = new Observation();
      
        $form = $this->form->createNamed('obs', ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($observation);

            $observation->setAuthor($this->storage->getToken()->getUser());
            $observation->setDate(new \DateTime());

            if ($this->securityChecker->isGranted('ROLE_NATURALISTE')) {
                $observation->setValidatedBy(($this->storage->getToken()->getUser()));
                $observation->setState(Observation::STATE_VALID);
            } else {
                $observation->setState(Observation::STATE_WAITING);
            }

            $em->flush();

            $this->session->getFlashBag()->add('success', "Votre observation a bien été ajouté !");

            return null;
        }

        return $form;
    }

}
