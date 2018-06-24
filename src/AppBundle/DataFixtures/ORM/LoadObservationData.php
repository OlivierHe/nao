<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Observation;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadObservationData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $taxRef1 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 1));
        $taxRef2 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 209));
        $taxRef3 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 301));
        $taxRef4 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 405));
        $taxRef5 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 507));
        $taxRef6 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 605));
        $taxRef7 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 720));
        $taxRef8 = $em->getRepository('AppBundle:Taxref')->findOneBy(array ('id' => 860));


        $obsVal = new Observation();
        $obsVal->setDate(new \DateTime('05-10-1990'));
        $obsVal->setState(Observation::STATE_VALID);
        $obsVal->setLatitude(48.624740);
        $obsVal->setLongitude(7.360840);
        $obsVal->setPhoto($this->getReference('photo1'));
        $obsVal->setAuthor($this->getReference('particulier'));
        $obsVal->setObservationDate(new \DateTime('05-10-1990'));
        $obsVal->setTaxref($taxRef1);

        $manager->persist($obsVal);

        $obsRef = new Observation();
        $obsRef->setDate(new \DateTime('05-10-2015'));
        $obsRef->setState(Observation::STATE_REFUSED);
        $obsRef->setLatitude(48.658236);
        $obsRef->setLongitude(-2.760847);
        $obsRef->setPhoto($this->getReference('photo3'));
        $obsRef->setAuthor($this->getReference('particulier'));
        $obsRef->setObservationDate(new \DateTime('05-10-2015'));
        $obsRef->setTaxref($taxRef2);

        $manager->persist($obsRef);

        $obsWait = new Observation();
        $obsWait->setDate(new \DateTime('31-05-2017'));
        $obsWait->setState(Observation::STATE_WAITING);
        $obsWait->setLatitude(50.784233);
        $obsWait->setLongitude(1.999512);
        $obsWait->setPhoto($this->getReference('photo2'));
        $obsWait->setAuthor($this->getReference('particulier'));
        $obsWait->setObservationDate(new \DateTime('31-05-2015'));
        $obsWait->setTaxref($taxRef3);

        $manager->persist($obsWait);

        $obsVal2 = new Observation();
        $obsVal2->setDate(new \DateTime('05-10-1993'));
        $obsVal2->setState(Observation::STATE_WAITING);
        $obsVal2->setLatitude(48.943249);
        $obsVal2->setLongitude(3.669434);
        $obsVal2->setPhoto($this->getReference('photo4'));
        $obsVal2->setAuthor($this->getReference('particulier'));
        $obsVal2->setObservationDate(new \DateTime('05-10-1993'));
        $obsVal2->setTaxref($taxRef4);

        $manager->persist($obsVal2);

        $obsVal3 = new Observation();
        $obsVal3->setDate(new \DateTime('05-10-2010'));
        $obsVal3->setState(Observation::STATE_VALID);
        $obsVal3->setLatitude(49.574212);
        $obsVal3->setLongitude(-1.516113);
        $obsVal3->setPhoto($this->getReference('photo5'));
        $obsVal3->setAuthor($this->getReference('particulier'));
        $obsVal3->setObservationDate(new \DateTime('05-10-2010'));
        $obsVal3->setTaxref($taxRef5);

        $manager->persist($obsVal3);

        $obsVal4 = new Observation();
        $obsVal4->setDate(new \DateTime('05-05-2013'));
        $obsVal4->setState(Observation::STATE_VALID);
        $obsVal4->setLatitude(43.380099);
        $obsVal4->setLongitude(3.405762);
        $obsVal4->setPhoto($this->getReference('photo6'));
        $obsVal4->setAuthor($this->getReference('particulier'));
        $obsVal4->setObservationDate(new \DateTime('05-05-2013'));
        $obsVal4->setTaxref($taxRef6);

        $manager->persist($obsVal4);

        $obsVal5 = new Observation();
        $obsVal5->setDate(new \DateTime('06-08-2016'));
        $obsVal5->setState(Observation::STATE_VALID);
        $obsVal5->setLatitude(45.543870);
        $obsVal5->setLongitude(-0.417480);
        $obsVal5->setPhoto($this->getReference('photo7'));
        $obsVal5->setAuthor($this->getReference('particulier'));
        $obsVal5->setObservationDate(new \DateTime('06-08-2016'));
        $obsVal5->setTaxref($taxRef7);

        $manager->persist($obsVal5);

        $obsVal6 = new Observation();
        $obsVal6->setDate(new \DateTime('07-02-2017'));
        $obsVal6->setState(Observation::STATE_VALID);
        $obsVal6->setLatitude(47.330446);
        $obsVal6->setLongitude(-2.175293);
        $obsVal6->setPhoto($this->getReference('photo8'));
        $obsVal6->setAuthor($this->getReference('particulier'));
        $obsVal6->setObservationDate(new \DateTime('07-02-2017'));
        $obsVal6->setTaxref($taxRef8);

        $manager->persist($obsVal6);


        $manager->flush();

    }

    public function getOrder()
    {
        return 4;
    }

}