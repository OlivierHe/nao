<?php
// tests/AppBundle/Repository/TaxrefRepositoryTest.php
namespace Tests\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaxrefRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    /**
    * @dataProvider paramProvider
    */
    public function testShowTaxref($q)
    {
        $results = $this->em
            ->getRepository('AppBundle:Taxref')
            ->showTaxref($q, 1);
        ;

        $this->assertCount(1, $results);
    }
    // injecte les valeur dans $q une par une
    public function paramProvider()
    {
        return array(
            array('a'),
            array('b'),
            array('c'),
            array('d'),
            array('e'),
            array('f'),
            array('g'),
            array('z')
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}

?>