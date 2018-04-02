<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Image;
use AppBundle\Entity\Trick;

class ImageTest extends TestCase
{
    /**
     *
     */
    public function testSetExtensionImage()
    {
        $image = new Image;
        $image->setExtension('jpg');
        $this->assertSame('jpg', $image->getExtension());
    }

    /**
     *
     */
    public function testSetAltImage()
    {
        $image = new Image;
        $image->setAlt('Indy');
        $this->assertSame('Indy', $image->getAlt());
    }

    /**
     *
     */
    public function testGetTrickNameImage()
    {
        $image = new Image;
        $trick = new Trick;

        $image->setTrick($trick);
        $trick->setName('Indy');
        
        $this->assertEquals('Indy', $image->getTrick()->getName());
    }
}
