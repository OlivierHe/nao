<?php
// tests/AppBundle/Services/GenerateObservationsTest.php
namespace Tests\AppBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GenerateObservationsTest extends WebTestCase
{
    // teste la protection et l'execution de la query l'affichage de valeur 
    public function testGetXml()
    {
        $client = static::createClient();
      
        // vérifie que la page est 403 accès refusé quand un utilisateur manipule la query avec des valeurs éronnées
        $crawler = $client->request('GET', '/observation_query?q=lkjlkjlkjerere');
        $this->assertTrue($client->getResponse()->isForbidden());

         // vérifie la réponse affichée pour une observation validée et affiché sur la carte
        $crawler = $client->request('GET', '/observation_query?q=605');
        $this->assertContains('Choucas de Daourie', $client->getResponse()->getContent());
    }
}

?>
