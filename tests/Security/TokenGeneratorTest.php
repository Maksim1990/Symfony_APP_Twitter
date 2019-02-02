<?php

namespace App\Tests\Security;


use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{

    public function testTokenGenerator()
    {
        $token=TokenGenerator::getRandomSecureToken(30);

        $this->assertEquals(30, strlen($token));
    }

}