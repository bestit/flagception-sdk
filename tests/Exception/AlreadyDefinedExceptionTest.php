<?php

namespace FeatureTox\Tests\Exception;

use FeatureTox\Exception\AlreadyDefinedException;
use FeatureTox\Exception\FeatureToxException;
use PHPUnit\Framework\TestCase;

/**
 * Class AlreadyDefinedExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Exception
 */
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
