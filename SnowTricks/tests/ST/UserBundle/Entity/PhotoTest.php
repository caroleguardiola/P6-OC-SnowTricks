<?php

namespace Tests\ST\UserBundle\Entity;

use PHPUnit\Framework\TestCase;
use ST\UserBundle\Entity\Photo;

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
