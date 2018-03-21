<?php

namespace Tests\ST\TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;

class ImageServiceTest extends WebTestCase
{
    public function testFindImageId()
    {

        //GIVEN
        $arrayOfImages = ['1, 2'];

        $imageRepository = $this->getMockBuilder(ImageRepository:: class)
            ->disableOriginalConstructor()
            ->getMock();
        $imageRepository
            ->expects($this->once())
            ->method('find')->willReturn($arrayOfImages);

        $imageService = new ImageService($imageRepository);

        //WHEN
        $result = $imageService->findAllWrapper();

        //THEN
        $this->assertEquals($arrayOfImages, $result);
    }
}

class ImageService 
{
    private $imageRepository;

    public function __construct(ImageRepository $repository)
    {
        $this->imageRepository = $repository;
    }

    public function findAllWrapper()
    {
        $arrayOfImages = ['1, 2'];
        return $this->imageRepository->find($arrayOfImages);
    }
}
