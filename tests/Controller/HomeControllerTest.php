<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomePage()
    {
        $this->assertSame(2, 1+1);
        $this->assertEquals(2, "1+1");
    }
}