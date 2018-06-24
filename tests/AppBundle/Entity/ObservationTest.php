<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Photo;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use AppBundle\Entity\Observation;

class ObservationTest extends TestCase
{

    public function testHydratation()
    {
        $photo = new Photo();
        $photo->setAlt('bird.jpg');
        $photo->setExtension('jpg');

        $author = new User();
        $naturalist = new User();


        $observation = new Observation();
        $observation->setLatitude('45.02222');
        $observation->setLongitude('14.25288');
        $observation->setAuthor($author);
        $observation->setTaxref('Oiseau');
        $observation->setPhoto($photo);
        $observation->setState(Observation::STATE_WAITING);
        $observation->setValidatedBy($naturalist);

        $this->assertEquals('14.25288', $observation->getLongitude());
        $this->assertEquals('45.02222', $observation->getLatitude());
        $this->assertEquals($author, $observation->getAuthor());
        $this->assertEquals('Oiseau', $observation->getTaxref());
        $this->assertEquals($photo, $observation->getPhoto());
        $this->assertEquals(Observation::STATE_WAITING, $observation->getState());
        $this->assertEquals( $naturalist, $observation->getValidatedBy());


    }
}