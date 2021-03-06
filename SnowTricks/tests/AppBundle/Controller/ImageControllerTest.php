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
use AppBundle\Entity\Image;
use AppBundle\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ImageControllerTest extends WebTestCase
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
     * @throws \ReflectionException
     */
    public function testImagesFindForDelete()
    {
        $reflectionClass = new \ReflectionClass(Image::class);
        $image = new Image;
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($image, 7777);

        $imageRepository = $this->createMock(ImageRepository::class);

        $imageRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo(7777))
            ->willReturn($image);

        $this->mockRepositories([
                ['AppBundle:Image', $imageRepository],
            ]);

        $this->logIn();
        $crawler = $this->client->request('GET', '/tricks/suppression images/7777');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Etes-vous certain de vouloir supprimer cette image")')->count());
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
}
