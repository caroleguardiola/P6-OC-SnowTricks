<?php

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Category;

class CategoryTest extends TestCase
{
    /**
     *
     */
    public function testSetNameCategory()
    {
        $category = new Category;
        $category->setName('Grab');
        $this->assertSame('Grab', $category->getName());
    }
}
