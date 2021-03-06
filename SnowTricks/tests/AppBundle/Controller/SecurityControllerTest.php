<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    /**
     *
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     *
     */
    public function testLoginIsUp()
    {
        $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testLogoutIsUp()
    {
        $this->client->request('GET', '/logout');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testRegisterIsUp()
    {
        $this->client->request('GET', '/register');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testForgotPasswordIsUp()
    {
        $this->client->request('GET', '/forgot_password/reset');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     *
     */
    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('submit-login')->form();
        $form['_username'] = 'Lisy';
        $form['_password'] = 'lisy';
        $this->client->submit($form);

        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur SnowTricks !")')->count());

        //echo $client->getResponse()->getContent();
    }

    /**
     *
     */
    public function testLinkLogin()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Connexion')->link();
        $crawler = $this->client->click($link);

        $info = $crawler->filter('h1')->text();
        $info = trim(preg_replace('/\s\s+/', ' ', $info)); // On retire les retours à la ligne pour faciliter la vérification

        $this->assertSame("Login", $info);
    }
}
