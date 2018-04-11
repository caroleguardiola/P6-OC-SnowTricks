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
        $this->assertNull($image->getId());
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
