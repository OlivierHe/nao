<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Observation;
use AppBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class UserTest extends TestCase
{
    public function testUser()
    {
        $user = new User ();
        $user->setGender('M');
        $user->setFirstName('Clément');
        $user->setName('MICHELIN');
        $user->setBirthDate($birthdate = new \DateTime('05-10-1990'));
        $user->setUsername('michelin.clement25@gmail.com');
        $user->setPseudo('clement25');
        $user->setPassword('blabla4837');
        $user->setRoles(array(user::PARTICULIER));
        $user->setAccount('Particulier');
        $user->setMember($memberOfAssociation = true);
        $user->setMember($notMemberOfAssociation = false);
        $user->setValidMail('1');
        $user->setDateRegistration($registration = new \DateTime('05/05/2017'));
        $user->setCodeValidation('eazijojg2papgaprlggmmao8');
        $user->setMentionsLegales('0');
        $user->addObservation(new Observation());
        $user->addObservation(new Observation());
        $user->addValidatedByUser(new Observation());
        $user->addValidatedByUser(new Observation());
        $user->addValidatedByUser(new Observation());


        $this->assertEquals('M', $user->getGender());
        $this->assertEquals('Clément', $user->getFirstName());
        $this->assertEquals('MICHELIN', $user->getName());
        $this->assertEquals($birthdate, $user->getBirthDate());
        $this->assertEquals('michelin.clement25@gmail.com', $user->getUsername());
        $this->assertEquals('clement25', $user->getPseudo());
        $this->assertEquals('blabla4837', $user->getPassword());
        $this->assertEquals($user->getRoles(),array(user::PARTICULIER));
        $this->assertEquals('Particulier', $user->getAccount());
        $this->assertTrue($memberOfAssociation, $user->getMember());
        $this->assertNotTrue($notMemberOfAssociation, $user->getMember());
        $this->assertEquals('1', $user->getValidMail());
        $this->assertEquals($registration, $user->getDateRegistration());
        $this->assertEquals('eazijojg2papgaprlggmmao8', $user->getCodeValidation());
        $this->assertEquals('0', $user->getMentionsLegales());

        $this->assertEquals(2, count($user->getObservations()));
        $this->assertEquals(3, count($user->getValidatedByUser()));



    }
}