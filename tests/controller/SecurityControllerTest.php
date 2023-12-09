<?php
// tests/Controller/SecurityControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Login');
    }

    public function testLoginFormSubmission()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Connexion')->form();
        $form['login[username]'] = 'testuser';
        $form['login[password]'] = 'password';

        $client->submit($form);

        $this->assertResponseRedirects('/secure_area_route'); // Adjust the redirection URL based on your application
    }
}
