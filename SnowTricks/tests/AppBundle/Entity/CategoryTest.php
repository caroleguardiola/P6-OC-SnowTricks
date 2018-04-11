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
