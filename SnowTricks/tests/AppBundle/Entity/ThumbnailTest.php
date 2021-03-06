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
use AppBundle\Entity\Thumbnail;
use AppBundle\Entity\Trick;

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
