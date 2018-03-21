<?php

namespace Tests\ST\TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ST\TricksBundle\Entity\Category;
use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Comment;
use ST\TricksBundle\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;

class TrickControllerTest extends WebTestCase
{
    private $client = null;
  
    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testHomePageIsUp()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur SnowTricks !")')->count());
    }
}
