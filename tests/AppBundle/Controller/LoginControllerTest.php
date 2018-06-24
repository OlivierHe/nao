<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// Test routes LoginController
class LoginControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/inscription'),
            array('/connexion'),
            array('/recover_password'),
            array('/valid_mail/1/una7w5j3ovk6y8ges2r9teadqdcxblo')
        );
    }

}