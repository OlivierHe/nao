<?php
namespace Tests\AppBundle\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserManagerTest extends WebTestCase
{
    public function testModify()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'particulier2@gmail.com',
            'PHP_AUTH_PW' => 'default',
        ));


        $crawler =  $client->request('GET', '/update_account');
        $form = $crawler->selectButton('update')->form();

        $form['user[username]'] = 'paf@gmail.com';
        $form['user[password][first]'] = 'default2222';
        $form['user[password][second]'] = 'default2222';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());


    }
}
?>
