<?php

namespace Tests\ST\TricksBundle\Entity;

use PHPUnit\Framework\TestCase;
use ST\TricksBundle\Entity\Video;
use ST\TricksBundle\Entity\Trick;

class VideoTest extends TestCase
{
    /**
     *
     */
    public function testSetUrlVideo()
    {
        $video = new Video;
        $video->setUrl('https://www.youtube.com/embed/iKkhKekZNQ8');
        $this->assertSame('https://www.youtube.com/embed/iKkhKekZNQ8', $video->getUrl());
    }

    /**
     *
     */
    public function testGetTrickNameVideo()
    {
        $video = new Video;
        $trick = new Trick;

        $video->setTrick($trick);
        $trick->setName('Indy');
        
        $this->assertEquals('Indy', $video->getTrick()->getName());
    }
}
