<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Video;
use AppBundle\Entity\Trick;

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
