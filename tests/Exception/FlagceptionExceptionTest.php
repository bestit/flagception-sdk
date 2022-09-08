<?php

namespace FeatureTox\Tests\Exception;

use Exception;
use FeatureTox\Exception\FeatureToxException;
use PHPUnit\Framework\TestCase;

/**
 * Class FeatureToxExceptionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Exception
 */
class FeatureToxExceptionTest extends TestCase
{
    /**
     * Test extends from base exception
     *
     * @return void
     */
    public function testExtends()
    {
        static::assertInstanceOf(Exception::class, new FeatureToxException());
    }
}
