<?php

namespace FeatureTox\Tests\Exception;

use FeatureTox\Exception\AlreadyDefinedException;
use FeatureTox\Exception\FeatureToxException;
use PHPUnit\Framework\TestCase;

class AlreadyDefinedExceptionTest extends TestCase
{
    /**
     * Test extends from base exception
     *
     * @return void
     */
    public function testExtends()
    {
        static::assertInstanceOf(FeatureToxException::class, new AlreadyDefinedException());
    }
}
