<?php

namespace FeatureTox\Tests\Exception;

use FeatureTox\Exception\ConstraintSyntaxException;
use FeatureTox\Exception\FeatureToxException;
use PHPUnit\Framework\TestCase;

/**
 * Class ConstraintSyntaxExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Exception
 */
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
