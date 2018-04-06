<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\CookieActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Tests the cookie activator
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Tests\Activator
 */
class CookieActivatorTest extends TestCase
{
    /**
     * Setup for each test
     *
     * @return void
     */
    protected function setUp()
    {
        // We have to unset for getting a clean $_COOKIE instance.
        unset($_COOKIE);
    }

    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(FeatureActivatorInterface::class, new CookieActivator([]));
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $activator = new CookieActivator([]);
        static::assertEquals('cookie', $activator->getName());
    }

    /**
     * Test feature is unknown
     *
     * @return void
     */
    public function testFeatureIsUnknown()
    {
       $activator = new CookieActivator([]);

       $_COOKIE['flagception'] = 'feature_abc';
       static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test feature is known
     *
     * @return void
     */
    public function testFeatureIsKnown()
    {
        $activator = new CookieActivator([
            'feature_abc'
        ]);

        $_COOKIE['flagception'] = 'feature_abc';
        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test multiple features
     *
     * @return void
     */
    public function testMultipleFeatures()
    {
        $activator = new CookieActivator([
            'feature_abc',
            'feature_def',
            'feature_ghi',
            'feature_xyz'
        ]);

        $_COOKIE['flagception'] = 'feature_abc,feature_def, feature_ghi, foobar';
        static::assertTrue($activator->isActive('feature_abc', new Context()));
        static::assertTrue($activator->isActive('feature_def', new Context()));
        static::assertTrue($activator->isActive('feature_ghi', new Context()));
        static::assertFalse($activator->isActive('foobar', new Context()));
        static::assertFalse($activator->isActive('feature_xyz', new Context()));
    }

    /**
     * Test changed cookie name is unknown
     *
     * @return void
     */
    public function testCookieNameChangeUnknown()
    {
        $activator = new CookieActivator([
            'feature_abc'
        ]);

        $_COOKIE['my_cookie'] = 'feature_abc';
        static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test changed cookie name is known
     *
     * @return void
     */
    public function testCookieNameChangeKnown()
    {
        $activator = new CookieActivator([
            'feature_abc'
        ], 'my_cookie');

        $_COOKIE['my_cookie'] = 'feature_abc';
        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test multiple features with changed separator
     *
     * @return void
     */
    public function testMultipleFeaturesWithChangedSeparator()
    {
        $activator = new CookieActivator([
            'feature_abc',
            'feature_def',
            'feature_ghi',
            'feature_xyz'
        ], 'flagception', '|');

        $_COOKIE['flagception'] = 'feature_abc |feature_def| feature_ghi|foobar';
        static::assertTrue($activator->isActive('feature_abc', new Context()));
        static::assertTrue($activator->isActive('feature_def', new Context()));
        static::assertTrue($activator->isActive('feature_ghi', new Context()));
        static::assertFalse($activator->isActive('foobar', new Context()));
        static::assertFalse($activator->isActive('feature_xyz', new Context()));
    }
}
