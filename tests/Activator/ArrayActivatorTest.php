<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\ArrayActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayActivatorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Tests\Activator
 */
class ArrayActivatorTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(FeatureActivatorInterface::class, new ArrayActivator());
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $activator = new ArrayActivator();
        static::assertEquals('array', $activator->getName());
    }

    /**
     * Test with empty array
     *
     * @return void
     */
    public function testWithEmptyArray()
    {
       $activator = new ArrayActivator();

       static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test feature is not in array
     *
     * @return void
     */
    public function testNotInArray()
    {
        $activator = new ArrayActivator([
            'feature_def'
        ]);

        static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test feature is in array
     *
     * @return void
     */
    public function testIsInArray()
    {
        $activator = new ArrayActivator([
            'feature_def',
            'feature_abc'
        ]);

        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }
}
