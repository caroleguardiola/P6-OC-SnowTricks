<?php

namespace Tests\ST\TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;


class ImageControllerTest extends WebTestCase
{
	public function testImagesDeleteFind()
	{
				
		$imageRepository = $this->createMock(ImageRepository:: class);

		$image = $imageRepository
			->expects($this->once())
			->method('find')
			->willReturn('145');

		$EntityManager = $this->createMock(EntityManager::class);
        
        $em = $EntityManager
        	->expects($this->any())
            ->method('getRepository')
            ->willReturn($imageRepository);

        $this->assertSame('145', $imageRepository->find('145'));
  
	}
}
