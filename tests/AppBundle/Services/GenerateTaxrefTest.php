<?php
// tests/AppBundle/Services/GenerateTaxrefTest.php
namespace Tests\AppBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GenerateTaxrefTest extends WebTestCase
{
    // teste la protection et l'execution de la query l'affichage de valeur 
    public function testGetJson()
    {
        $client = static::createClient();
      
        // teste l'accès refusé en cas de valeur éronnée
        $crawler = $client->request('GET', '/taxref_query');
        $this->assertTrue($client->getResponse()->isForbidden());
    
        // teste la valeur affichée sur une requette
        $crawler = $client->request('GET', '/taxref_query?q=a&page=1');
        $this->assertContains('Vieillot', $client->getResponse()->getContent());
    }
}

?>
