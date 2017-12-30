<?php

namespace Flagception\Tests\Exception;

use Flagception\Exception\AlreadyDefinedException;
use Flagception\Exception\FlagceptionException;
use PHPUnit\Framework\TestCase;

/**
 * Class AlreadyDefinedExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Exception
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
        static::assertInstanceOf(FlagceptionException::class, new AlreadyDefinedException());
    }
}
