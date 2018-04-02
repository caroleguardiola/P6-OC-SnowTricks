<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Trick;
use AppBundle\Entity\Category;
use AppBundle\Entity\Thumbnail;

class TrickTest extends TestCase
{
    /**
     *
     */
    public function testSetNameTrick()
    {
        $trick = new Trick;
        $trick->setName('Indy');
        $this->assertSame('Indy', $trick->getName());
    }

    /**
     *
     */
    public function testSetDescriptionTrick()
    {
        $trick = new Trick;
        $trick->setDescription('saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière');
        $this->assertSame('saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière', $trick->getDescription());
    }

    /**
     *
     */
    public function testSetDateCreationTrick()
    {
        $trick = new Trick;
        $trick->setDateCreation('2018-02-14 17:32:00');
        $this->assertSame('2018-02-14 17:32:00', $trick->getDateCreation());
    }

    /**
     *
     */
    public function testSetUpdatedAtTrick()
    {
        $trick = new Trick;
        $trick->setUpdatedAt('2018-02-14 17:32:00');
        $this->assertSame('2018-02-14 17:32:00', $trick->getUpdatedAt());
    }

    /**
     *
     */
    public function testSetCategoryTrick()
    {
        $trick = new Trick;
        $category = new Category;

        $trick->setCategory($category);
        
        $this->assertEquals($category, $trick->getCategory());
    }

    /**
     *
     */
    public function testGetCategoryNameTrick()
    {
        $trick = new Trick;
        $category = new Category;

        $trick->setCategory($category);
        $category->setName('Grabs');
        
        $this->assertEquals('Grabs', $trick->getCategory()->getName());
    }

    /**
     *
     */
    public function testGetThumbnailAltTrick()
    {
        $trick = new Trick;
        $thumbnail = new Thumbnail;

        $trick->setThumbnail($thumbnail);
        $thumbnail->setAlt('Indy');
        
        $this->assertEquals('Indy', $trick->getThumbnail()->getAlt());
    }
}
