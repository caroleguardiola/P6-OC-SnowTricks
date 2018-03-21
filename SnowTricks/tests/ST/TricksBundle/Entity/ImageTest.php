<?php

namespace Tests\ST\TricksBundle\Entity;

use PHPUnit\Framework\TestCase;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Entity\Trick;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageTest extends TestCase
{
    public function testSetExtensionImage()
    {
        $image = new Image;
        $image->setExtension('jpg');
        $this->assertSame('jpg', $image->getExtension());
    }

    public function testSetAltImage()
    {
        $image = new Image;
        $image->setAlt('Indy');
        $this->assertSame('Indy', $image->getAlt());
    }

    public function testGetTrickNameImage()
    {
        $image = new Image;
        $trick = new Trick;

        $image->setTrick($trick);
        $trick->setName('Indy');
        
        $this->assertEquals('Indy', $image->getTrick()->getName());
    }
}
