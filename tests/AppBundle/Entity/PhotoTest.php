<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PhotoTest extends TestCase
{

    public function testHydratation()
    {
        $photo = new Photo();
        $photo->setAlt('bird.jpg');
        $photo->setExtension('jpg');

        $this->assertEquals('bird.jpg', $photo->getAlt());
        $this->assertEquals('jpg', $photo->getExtension());
        

    }
}