<?php

namespace App\Tests\Entity;

use App\Entity\Figure;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    //Tester si la collection de figures sur une nouvelles categories est null
    public function NewCreatedCategoryReturnsEmptyFiguresArray()
    {
        $newCat = (new Category())
                    ->setName("My new categorie");
                    
        $this->assertEquals(null, $newCat->getFigures());       
    }
}