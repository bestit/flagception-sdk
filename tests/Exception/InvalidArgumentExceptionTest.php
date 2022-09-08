<?php

namespace FeatureTox\Tests\Exception;

use FeatureTox\Exception\InvalidArgumentException;
use FeatureTox\Exception\FeatureToxException;
use PHPUnit\Framework\TestCase;

class InvalidArgumentExceptionTest extends TestCase
{
    /**
     * Test extends from base exception
     *
     * @return void
     */
    public function testExtends()
    {
        static::assertInstanceOf(FeatureToxException::class, new InvalidArgumentException());
    }
}
