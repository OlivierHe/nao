<?php

namespace Tests\AppBundle\Services;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class SecuriteTest extends WebTestCase
{

    public function testRegister(){

        $client = static::createClient();

        $crawler = $client->request('GET', '/inscription');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('h1:contains("Informations personnelles")')->count());

        $form = $crawler->selectButton('submitInscription')->form();



        $form['inscription[gender]']     = 'Masculin';
        $form['inscription[name]']       = 'MICHELIN';
        $form['inscription[firstName]']      = 'Clément';
        $form['inscription[username]']    = 'clement-25@gmail.com';
        $form['inscription[pseudo]']    = 'clement-25';
        $form['inscription[birthDate]']    =  '05-10-1990';
        $form['inscription[password][first]']    = '78hua32kl';
        $form['inscription[password][second]']    = '78hua32kl';
        $form['inscription[mentionsLegales]']    = '1';


        $client->submit($form);

        if ($profile = $client->getProfile()) {
            $swiftMailerProfiler = $profile->getCollector('swiftmailer');

            // Seulement 1 message doit avoir été envoyé
            $this->assertEquals(1, $swiftMailerProfiler->getMessageCount());

            // On récupère le premier message
            $messages = $swiftMailerProfiler->getMessages();
            $message  = array_shift($messages);

            $emailRegister = 'clement-25@gmail.com';
            // On vérifie que le message a été envoyé à la bonne adresse
            $this->assertArrayHasKey($emailRegister, $message->getTo());
        }

        $this->assertTrue($client->getResponse()->isRedirection());

        $crawler = $client->followRedirect();

        // on vérifie que le message flashbag de validation apparraît bien
        $this->assertEquals(1, $crawler->filter('.testFlash:contains("Vous allez recevoir une demande de confirmation sur votre adresse email")')->count());

    }


    public function testGetConnexion(){

        $client = static::createClient();

        $crawler = $client->request('GET', '/connexion');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('h1:contains("Connexion")')->count());

        $form = $crawler->selectButton('submitConnexion')->form();

        $form['_username']     = 'naturaliste@gmail.com';
        $form['_password']       = 'default';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirection());

        $crawler = $client->followRedirect();

        $this->assertEquals(1, $crawler->filter('h1:contains(" Détails de l\'observation ")')->count());
    }

    public function testRecoverPassword(){

        $client = static::createClient();

        $crawler = $client->request('GET', '/recover_password');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(1, $crawler->filter('h1:contains("Nouveau mot de passe")')->count());


        $form = $crawler->selectButton('submitRecoverPassword')->form();

        $form['recovery_password[username]']     = 'naturaliste@gmail.com';
        $form['recovery_password[birthDate]']       = '05-10-1992';

        $client->submit($form);


        if ($profile = $client->getProfile()) {
            $swiftMailerProfiler = $profile->getCollector('swiftmailer');

            // Seulement 1 message doit avoir été envoyé
            $this->assertEquals(1, $swiftMailerProfiler->getMessageCount());

            // On récupère le premier message
            $messages = $swiftMailerProfiler->getMessages();
            $message  = array_shift($messages);

            $emailRegister = 'naturaliste@gmail.com';
            // On vérifie que le message a été envoyé à la bonne adresse
            $this->assertArrayHasKey($emailRegister, $message->getTo());
        }

        $this->assertTrue($client->getResponse()->isRedirection());

        $crawler = $client->followRedirect();

        $this->assertEquals(1, $crawler->filter('.testFlash:contains("Vous allez recevoir un nouveau mot de passe dans votre boite email")')->count());
    }

}