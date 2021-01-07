<?php

namespace App\Tests\Controller;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class AdminCategoryControllerTest extends TestCase
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