<?php
// tests/AppBundle/Repository/ObservationRepositoryTest.php
namespace Tests\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ObservationRepositoryTest extends KernelTestCase
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
    // test que le nombre d'observations est égal à 7
    public function testGetAll() {

        $results = $this->em
            ->getRepository('AppBundle:Observation')
            ->getAll();
        
        $this->assertCount(5, $results);
    }

    // test les id de taxref dans le repository observations validée
    public function testGetByIdTaxref()
    {
        $results = $this->em
            ->getRepository('AppBundle:Observation')
            ->getByIdTaxref(720);
        
        $this->assertCount(1, $results);

            $results = $this->em
            ->getRepository('AppBundle:Observation')
            ->getByIdTaxref(605);
        
        $this->assertCount(1, $results);

            $results = $this->em
            ->getRepository('AppBundle:Observation')
            ->getByIdTaxref(507);
        
        $this->assertCount(1, $results);
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
