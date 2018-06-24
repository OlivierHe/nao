<?php

namespace tests\AppBundle\Entity;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use AppBundle\Entity\Taxref;

class TaxrefTest extends TestCase
{

    public function testHydratation()
    {
  

        $taxRef = new Taxref();
        $taxRef->setNomRef('Vautouritus cyborgotus');
        $taxRef->setSynCre('Vatatour cybobo');
        $taxRef->setNomVern('Vautour robotisé');
        $taxRef->setOrdre('birdy');
        $taxRef->setFamille('cyborg');
        $taxRef->setCdRef('09809');
        $taxRef->setCdNom('90909');

        $this->assertEquals('Vautouritus cyborgotus', $taxRef->getNomRef());
        $this->assertEquals('Vatatour cybobo', $taxRef->getSynCre());
        $this->assertEquals('Vautour robotisé', $taxRef->getNomVern());
        $this->assertEquals('birdy', $taxRef->getOrdre());
        $this->assertEquals('cyborg', $taxRef->getFamille());
        $this->assertEquals('09809', $taxRef->getCdRef());
        $this->assertEquals('90909', $taxRef->getCdNom());


    }
}