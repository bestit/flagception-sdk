<?php

namespace FeatureTox\Tests\Activator;

use FeatureTox\Activator\ArrayActivator;
use FeatureTox\Activator\FeatureActivatorInterface;
use FeatureTox\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayActivatorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Activator
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

    /**
     * Test feature is in array (key => value)
     *
     * @return void
     */
    public function testIsInArrayKeyValue()
    {
        $activator = new ArrayActivator([
            'feature_def',
            'feature_abc' => true
        ]);

        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test feature is in array but false
     *
     * @return void
     */
    public function testIsInArrayButFalse()
    {
        $activator = new ArrayActivator([
            'feature_def',
            'feature_abc' => false
        ]);

        static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test feature is in array / cast from integer
     *
     * @return void
     */
    public function testIsInArrayCastFromInteger()
    {
        $activator = new ArrayActivator([
            'feature_def',
            'feature_abc' => 1,
            'feature_ghi' => 0
        ]);

        static::assertTrue($activator->isActive('feature_abc', new Context()));
        static::assertFalse($activator->isActive('feature_ghi', new Context()));
    }

    /**
     * Test feature is in array / cast from string
     *
     * @return void
     */
    public function testIsInArrayCastFromString()
    {
        $activator = new ArrayActivator([
            'feature_def',
            'feature_abc' => 'true',
            'feature_ghi' => 'false',
        ]);

        static::assertTrue($activator->isActive('feature_abc', new Context()));
        static::assertFalse($activator->isActive('feature_ghi', new Context()));
    }
}
