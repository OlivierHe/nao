<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// teste les routes du controlleur
class ApiControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccesful($url)
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@gmail.com',
            'PHP_AUTH_PW'   => 'default',
        ));

        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testPageIsSuccesfulWithParamaters()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@gmail.com',
            'PHP_AUTH_PW'   => 'default',
        ));


        $client->request('GET', '/observation_update_state_query',
            array('idobs' => 3,'idespece' => 25, 'state' => 1));

        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/observation_delete_query',
            array('idobs' => 4, 'auteur' => 'Kolor'));

        $this->assertTrue($client->getResponse()->isSuccessful());


    }
 
    public function testPageIsForbidden()
    {
        $client = self::createClient();

        $client->request('GET', '/taxref_query');
        $this->assertTrue($client->getResponse()->isForbidden());
        $client->request('GET', '/observation_query');
        $this->assertTrue($client->getResponse()->isForbidden());
    }

    public function urlProvider()
    {
        return array(
            array('/observation_validee_query'),
            array('/observation_attente_query'),
            array('/observation_status_query'),
        );
    }

}
