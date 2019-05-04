<?php

namespace Flagception\Tests\Exception;

use Flagception\Exception\InvalidArgumentException;
use Flagception\Exception\FlagceptionException;
use PHPUnit\Framework\TestCase;

/**
 * Class InvalidArgumentExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Exception
 */
class InvalidArgumentExceptionTest extends TestCase
{
    /**
     * Test extends from base exception
     *
     * @return void
     */
    public function testExtends()
    {
        static::assertInstanceOf(FlagceptionException::class, new InvalidArgumentException());
    }
}
