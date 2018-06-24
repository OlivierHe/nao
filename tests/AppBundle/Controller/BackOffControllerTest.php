<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// teste les routes du controlleur
class BackOffControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function  testPageIsSuccessful($url)
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@gmail.com',
            'PHP_AUTH_PW'   => 'default',
        ));

        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }


    public function urlProvider()
    {
        return array(
            array('/ajouter_observation'),
            array('/admin'),
            array('/mes_observations'),
            array('/observations_validees'),
            array('/update_account'),
            array('/validations_attentes'),
            array('/exportation_bdd')     
        );
    }
   
}
