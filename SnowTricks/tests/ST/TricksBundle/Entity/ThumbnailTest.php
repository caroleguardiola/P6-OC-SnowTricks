<?php

namespace Tests\ST\TricksBundle\Entity;

use PHPUnit\Framework\TestCase;
use ST\TricksBundle\Entity\Thumbnail;
use ST\TricksBundle\Entity\Trick;

class ThumbnailTest extends TestCase
{
    /**
     *
     */
    public function testSetExtensionThumbnail()
    {
        $thumbnail = new Thumbnail;
        $thumbnail->setExtension('jpg');
        $this->assertSame('jpg', $thumbnail->getExtension());
    }

    /**
     *
     */
    public function testSetAltThumbnail()
    {
        $thumbnail = new Thumbnail;
        $thumbnail->setAlt('Indy');
        $this->assertSame('Indy', $thumbnail->getAlt());
    }

    /**
     *
     */
    public function testGetTrickNameThumbnail()
    {
        $thumbnail = new Thumbnail;
        $trick = new Trick;

        $thumbnail->setTrick($trick);
        $trick->setName('Indy');
        
        $this->assertEquals('Indy', $thumbnail->getTrick()->getName());
    }
}
