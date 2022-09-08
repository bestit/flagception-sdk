<?php

namespace FeatureTox\Tests\Exception;

use FeatureTox\Exception\ConstraintSyntaxException;
use FeatureTox\Exception\FeatureToxException;
use PHPUnit\Framework\TestCase;

class ConstraintSyntaxExceptionTest extends TestCase
{
    /**
     * Test extends from base exception
     *
     * @return void
     */
    public function testExtends()
    {
        static::assertInstanceOf(FeatureToxException::class, new ConstraintSyntaxException());
    }
}
