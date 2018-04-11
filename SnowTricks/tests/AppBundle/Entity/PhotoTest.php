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
use AppBundle\Entity\Photo;

class PhotoTest extends TestCase
{
    /**
     *
     */
    public function testSetExtensionPhoto()
    {
        $photo = new Photo;
        $photo->setExtension('png');
        $this->assertSame('png', $photo->getExtension());
    }

    /**
     *
     */
    public function testSetAltPhoto()
    {
        $photo = new Photo;
        $photo->setAlt('Lisy');
        $this->assertSame('Lisy', $photo->getAlt());
    }
}
