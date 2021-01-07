<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomaPage()
    {
        $this->assertSame(2, 1+1);
    }
}