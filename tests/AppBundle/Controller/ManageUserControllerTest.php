<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// teste les routes du controlleur
class ManageUserControllerTest extends WebTestCase
{
  
    public function testPageIsSuccesful()
    {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@gmail.com',
            'PHP_AUTH_PW'   => 'default',
        ));

        $client->request('GET', '/users_query');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/gestion_membres');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/gestion_membres_form',
            array('id' => 3));
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('POST', '/ask-another-justificatory',
            array('id' => 3));
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/download-justificatory/1');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('POST', '/gestion_membres_delete',
            array('id' => 3));
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

   
}
