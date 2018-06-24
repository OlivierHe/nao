<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Photo;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadPhotoData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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

   
        $photo1 = new Photo();
        $photo1->setExtension('jpeg');
        $photo1->setAlt('photo 1');

        $manager->persist($photo1);

        $photo2 = new Photo();
        $photo2->setExtension('jpg');
        $photo2->setAlt('photo 2');

        $manager->persist($photo2);

        $photo3 = new Photo();
        $photo3->setExtension('gif');
        $photo3->setAlt('photo 3');

        $manager->persist($photo3);

        $photo4 = new Photo();
        $photo4->setExtension('jpeg');
        $photo4->setAlt('photo 4');

        $manager->persist($photo4);

        $photo5 = new Photo();
        $photo5->setExtension('jpg');
        $photo5->setAlt('photo 5');

        $manager->persist($photo5);

        $photo6 = new Photo();
        $photo6->setExtension('jpg');
        $photo6->setAlt('photo 6');

        $manager->persist($photo6);

        $photo7 = new Photo();
        $photo7->setExtension('jpg');
        $photo7->setAlt('photo 7');

        $manager->persist($photo7);

        $photo8 = new Photo();
        $photo8->setExtension('jpg');
        $photo8->setAlt('photo 8');

        $manager->persist($photo8);

        $photo9 = new Photo();
        $photo9->setExtension('png');
        $photo9->setAlt('photo 9');

        $manager->persist($photo9);

        $manager->flush();

        $this->addReference('photo1', $photo1);
        $this->addReference('photo2', $photo2);
        $this->addReference('photo3', $photo3);
        $this->addReference('photo4', $photo4);
        $this->addReference('photo5', $photo5);
        $this->addReference('photo6', $photo6);
        $this->addReference('photo7', $photo7);
        $this->addReference('photo8', $photo8);
        $this->addReference('photo9', $photo9);

    }

    public function getOrder()
    {
        return 1;
    }

}