<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\CookieActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Exception\InvalidArgumentException;
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
     *
     * @throws InvalidArgumentException
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(FeatureActivatorInterface::class, new CookieActivator([]));
    }

    /**
     * Test name
     *
     * @return void
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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

    /**
     * Test multiple features by blacklist
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function testMultipleFeaturesByBlacklist()
    {
        $activator = new CookieActivator([
            'feature_abc',
            'feature_def',
            'feature_ghi',
            'feature_xyz'
        ], 'flagception', ',', CookieActivator::BLACKLIST);

        $_COOKIE['flagception'] = 'feature_abc,feature_def, feature_ghi, foobar';
        static::assertFalse($activator->isActive('feature_abc', new Context()));
        static::assertFalse($activator->isActive('feature_def', new Context()));
        static::assertFalse($activator->isActive('feature_ghi', new Context()));
        static::assertTrue($activator->isActive('foobar', new Context()));
        static::assertFalse($activator->isActive('feature_xyz', new Context()));
    }

    /**
     * Test public constants
     *
     * @return void
     */
    public function testConstants()
    {
        static::assertEquals('whitelist', CookieActivator::WHITELIST);
        static::assertEquals('blacklist', CookieActivator::BLACKLIST);
    }

    /**
     * Test if "whitelist" is a valid argument as mode
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function testWhitelistModeArgument()
    {
        $activator = new CookieActivator([], 'flagception', ',', 'whitelist');
        static::assertEquals('cookie', $activator->getName());
    }

    /**
     * Test if "blacklist" is a valid argument as mode
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function testBlacklistModeArgument()
    {
        $activator = new CookieActivator([], 'flagception', ',', 'blacklist');
        static::assertEquals('cookie', $activator->getName());
    }

    /**
     * Test if "foobar" is an invalid argument as mode
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function testFoobarModeArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        new CookieActivator([], 'flagception', ',', 'foobar');
    }
}
