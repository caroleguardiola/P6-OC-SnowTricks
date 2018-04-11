<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Category;
use AppBundle\Entity\Trick;
use AppBundle\Entity\Comment;
use AppBundle\Repository\TrickRepository;
use AppBundle\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;

class TrickControllerTest extends WebTestCase
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
    public function testHomePageIsUp()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur SnowTricks !")')->count());
    }

    /**
     * @param $repositories
     * @throws \ReflectionException
     */
    private function mockRepositories($repositories)
    {
        $EntityManager = $this->createMock(EntityManager::class);
        
        $EntityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($repositories));

        $this->client->getcontainer()->set('doctrine.orm.default_entity_manager', $EntityManager);
    }

    /**
     *
     */
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

    /**
     * @throws \ReflectionException
     */
    public function testTrickShow()
    {
        $comment = new Comment;
        $comment->setContent('Génial !!');

        $commentRepository = $this->createMock(CommentRepository:: class);

        $commentRepository
            ->expects($this->any())
            ->method('findByTrick')
            ->willReturn([]);

        $reflectionClass = new \ReflectionClass(Trick::class);

        $trick = new Trick;
        $trick->setCategory(new Category);
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($trick, 7777);

        $trickRepository = $this->createMock(TrickRepository:: class);

        $trickRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($trick);

        $this->mockRepositories([
                ['AppBundle:Trick', $trickRepository],
                ['AppBundle:Comment', $commentRepository],
            ]);

        $crawler = $this->client->request('GET', '/tricks/details/7777');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Trick créé le :")')->count());
    }

    /**
     * @throws \ReflectionException
     */
    public function testTrickFindForDelete()
    {
        $reflectionClass = new \ReflectionClass(Trick::class);

        $trick = new Trick;
        $trick->setCategory(new Category);
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($trick, 7777);
        $trick->setName('Blabla');

        $trickRepository = $this->createMock(TrickRepository:: class);

        $trickRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($trick);

        $this->mockRepositories([
                ['AppBundle:Trick', $trickRepository],
            ]);

        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/suppression/7777');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Etes-vous certain de vouloir supprimer le trick "Blabla"")')->count());
    }
}
