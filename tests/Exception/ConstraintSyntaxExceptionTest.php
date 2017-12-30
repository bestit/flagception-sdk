<?php

namespace Flagception\Tests\Exception;

use Flagception\Exception\ConstraintSyntaxException;
use Flagception\Exception\FlagceptionException;
use PHPUnit\Framework\TestCase;

/**
 * Class ConstraintSyntaxExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Exception
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
        static::assertInstanceOf(FlagceptionException::class, new ConstraintSyntaxException());
    }
}
