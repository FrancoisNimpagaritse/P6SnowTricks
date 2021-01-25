<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryEntity extends TestCase
{
    public function testCreateNewCategory()
    {
        $category = (new Category())
                    ->setName("Category Test")
                    ;
        $this->assertSame("Category Test", $category->getName());
        $this->assertSame(null, $category->getId());
    }
}