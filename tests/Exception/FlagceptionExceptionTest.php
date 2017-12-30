<?php

namespace Flagception\Tests\Exception;

use Exception;
use Flagception\Exception\FlagceptionException;
use PHPUnit\Framework\TestCase;

/**
 * Class FlagceptionExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Exception
 */
class FlagceptionExceptionTest extends TestCase
{
    /**
     * Test extends from base exception
     *
     * @return void
     */
    public function testExtends()
    {
        static::assertInstanceOf(Exception::class, new FlagceptionException());
    }
}
