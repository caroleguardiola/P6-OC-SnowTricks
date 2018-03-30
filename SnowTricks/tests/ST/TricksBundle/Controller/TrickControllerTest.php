<?php

namespace Tests\ST\TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ST\TricksBundle\Entity\Category;
use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Comment;
use ST\TricksBundle\Repository\TrickRepository;
use ST\TricksBundle\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;

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

    private function mockRepositories($repositories)
    {
        $EntityManager = $this->createMock(EntityManager::class);
        
        $EntityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($repositories));

        $this->client->getcontainer()->set('doctrine.orm.default_entity_manager', $EntityManager);
    }

    public function testTrickShow()
    {
        $comment = new Comment;
        $comment->setContent('Génial !!');

        $commentRepository = $this->createMock(CommentRepository:: class);

        $commentRepository
            ->expects($this->any())
            ->method('findByTrick')
            ->willReturn([]);

        $trick = new Trick;
        $trick->setCategory(new Category);
        $trick->setId(7777);

        $trickRepository = $this->createMock(TrickRepository:: class);

        $trickRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($trick);

        $this->mockRepositories([
                ['TricksBundle:Trick', $trickRepository],
                ['TricksBundle:Comment', $commentRepository],
            ]);

        $crawler = $this->client->request('GET', '/tricks/details/7777');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Trick créé le :")')->count());
    }

    public function testTrickFindForDelete()
    {
        $trick = new Trick;
        $trick->setCategory(new Category);
        $trick->setId(7777);
        $trick->setName('Blabla');

        $trickRepository = $this->createMock(TrickRepository:: class);

        $trickRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($trick);

        $this->mockRepositories([
                ['TricksBundle:Trick', $trickRepository],
            ]);

        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/suppression/7777');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Etes-vous certain de vouloir supprimer le trick "Blabla"")')->count());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_USER'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
