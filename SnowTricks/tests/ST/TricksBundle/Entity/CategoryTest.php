<?php

namespace Tests\ST\TricksBundle\Entity;

use PHPUnit\Framework\TestCase;
use ST\TricksBundle\Entity\Category;
use ST\TricksBundle\Entity\Trick;

class CategoryTest extends TestCase
{
    public function testSetNameCategory()
    {
        $category = new Category;
        $category->setName('Grab');
        $this->assertSame('Grab', $category->getName());
    }
}
