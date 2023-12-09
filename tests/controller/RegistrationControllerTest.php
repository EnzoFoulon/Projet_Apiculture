<?php
// tests/Controller/RegistrationControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegistrationPageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Inscription');
    }

    public function testRegistrationFormSubmission()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form();
        $form['registration[email]'] = 'test@example.com';
        $form['registration[username]'] = 'testuser';
        $form['registration[password][first]'] = 'password';
        $form['registration[password][second]'] = 'password';

        $client->submit($form);

        $this->assertResponseRedirects('/home'); // Adjust the redirection URL based on your application
    }
}
