<?php

namespace Tests\ST\TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;

class ImageControllerTest extends WebTestCase
{
    private $client = null;
  
    public function setUp()
    {
        $this->client = static::createClient();
    }

    private function mockRepositories($repositories)
    {
        $EntityManager = $this->createMock(EntityManager::class);
        
        $EntityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($repositories));

        $this->client->getcontainer()->set('doctrine.orm.default_entity_manager', $EntityManager);
    }

    public function testImagesFindForDelete()
    {
        $image = new Image;
        $image->setId(7777);

        $imageRepository = $this->createMock(ImageRepository:: class);

        $imageRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($image);

        $this->mockRepositories([
                ['TricksBundle:Image', $imageRepository],
            ]);

        $crawler = $this->client->request('GET', '/tricks/suppression images/7777');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Etes-vous certain de vouloir supprimer cette image")')->count());
        echo $this->client->getResponse()->getContent();
    }
}
