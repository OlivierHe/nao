<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddObservationTest extends WebTestCase
{

    public function  testPageIsSuccessful()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin@gmail.com',
            'PHP_AUTH_PW' => 'default',
        ));

        $crawler = $client->request('GET', '/ajouter_observation');

        $form = $crawler->selectButton('valid-btn')->form();

        $form['obs[taxref]']  = '671';
        $form['obs[observationDate]'] = '1-06-2017';
        $form['obs[latitude]']  = '14.222';
        $form['obs[longitude]']  = '52.222';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirection());
        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());

    }

}
