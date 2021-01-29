<?php

namespace App\Tests\TestController;

use App\Entity\Category;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AccountControllerTest extends TestCase
{
    public function testMocks()
    {
        $categ = new Category();
        $mock = $this->createMock(Figure::class);

        $mock->method('setCategory')
            ->willReturn(true);

        //$result = $mock->setCategory($categ);


        //$this->assertEquals(true, $result);
    }
}