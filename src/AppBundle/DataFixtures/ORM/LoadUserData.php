<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    public function load(ObjectManager $manager)
    {

        // load user Admin
        $userAdmin = new User();
        $userAdmin->setGender('Masculin');
        $userAdmin->setFirstName('Clément');
        $userAdmin->setName('blabla');
        $userAdmin->setBirthDate(new \DateTime('05-10-1990'));
        $userAdmin->setAccount('Administrateur');
        $userAdmin->setMember(true);
        $userAdmin->setUsername('admin@gmail.com');
        $userAdmin->setPseudo('Clement52');
        $userAdmin->setValidMail(true);
        $userAdmin->setMentionsLegales(true);
        $this->cryptPassword($userAdmin, 'default');



        $userAdmin->setRoles(array('ROLE_ADMIN'));

        $manager->persist($userAdmin);
        $manager->flush();

        $userNaturaliste = new User();
        $userNaturaliste->setGender('Masculin');
        $userNaturaliste->setFirstName('Yerowell');
        $userNaturaliste->setName('blabla');
        $userNaturaliste->setBirthDate(new \DateTime('05-10-1992'));
        $userNaturaliste->setAccount("Naturaliste");
        $userNaturaliste->setMember(true);
        $userNaturaliste->setUsername('naturaliste@gmail.com');
        $userNaturaliste->setPseudo('Yero');
        $userNaturaliste->setValidMail(false);
        $userNaturaliste->setMentionsLegales(true);
        $this->cryptPassword($userNaturaliste, 'default');


        $userNaturaliste->setRoles(array('ROLE_NATURALISTE'));


        $manager->persist($userNaturaliste);
        $manager->flush();

        $userParticulier = new User();
        $userParticulier->setGender('Masculin');
        $userParticulier->setFirstName('Olivier');
        $userParticulier->setName('blabla');
        $userParticulier->setBirthDate(new \DateTime('05-10-1975'));
        $userParticulier->setAccount("Particulier");
        $userParticulier->setMember(false);
        $userParticulier->setUsername('particulier@gmail.com');
        $userParticulier->setPseudo('Olive');
        $userParticulier->setValidMail(false);
        $userParticulier->setMentionsLegales(true);
        $this->cryptPassword($userParticulier, 'default');

        $userParticulier->setRoles(array('ROLE_EN_ATTENTE_DE_VALIDATION'));

        $manager->persist($userParticulier);

        $manager->flush();

        $userParticulier = new User();
        $userParticulier->setGender('Masculin');
        $userParticulier->setFirstName('Jonh');
        $userParticulier->setName('Treno');
        $userParticulier->setBirthDate(new \DateTime('08-10-1975'));
        $userParticulier->setAccount("Particulier");
        $userParticulier->setMember(true);
        $userParticulier->setUsername('particulier2@gmail.com');
        $userParticulier->setPseudo('Jerno');
        $userParticulier->setValidMail(true);
        $userParticulier->setMentionsLegales(true);
        $this->cryptPassword($userParticulier, 'default');

        $userParticulier->setRoles(array('ROLE_PARTICULIER'));

        $manager->persist($userParticulier);

        $manager->flush();

        $userParticulier = new User();
        $userParticulier->setGender('Masculin');
        $userParticulier->setFirstName('Alex');
        $userParticulier->setName('Gavor');
        $userParticulier->setBirthDate(new \DateTime('02-01-1988'));
        $userParticulier->setAccount("Particulier");
        $userParticulier->setMember(true);
        $userParticulier->setUsername('particulier3@gmail.com');
        $userParticulier->setPseudo('Kolor');
        $userParticulier->setValidMail(true);
        $userParticulier->setMentionsLegales(true);
        $this->cryptPassword($userParticulier, 'default');

        $userParticulier->setRoles(array('ROLE_PARTICULIER'));

        $manager->persist($userParticulier);

        $manager->flush();

        $this->addReference('admin', $userAdmin);
        $this->addReference('naturaliste', $userNaturaliste);
        $this->addReference('particulier', $userParticulier);


    }

    public function cryptPassword(User $user, $plainPassword)
    {

        $encoder = $this->container->get('security.password_encoder');

        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
    }

    public function getOrder()
    {
        return 2;
    }


}