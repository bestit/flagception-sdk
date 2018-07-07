<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\ArrayActivator;
use Flagception\Activator\CacheActivator;
use Flagception\Activator\ChainActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Tests the cache activator
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Tests\Activator
 */
class CacheActivatorTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(FeatureActivatorInterface::class, new ChainActivator());
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $activator = new CacheActivator(
            new ArrayActivator(),
            $this->createMock(CacheItemPoolInterface::class)
        );

        static::assertEquals('array', $activator->getName());
    }

    /**
     * Test activator
     *
     * @return void
     */
    public function testActivator()
    {
        $activator = new CacheActivator(
            $instance = new ArrayActivator(),
            $this->createMock(CacheItemPoolInterface::class)
        );

        static::assertSame($instance, $activator->getActivator());
    }

    /**
     * Test feature is active from cache
     *
     * @return void
     */
    public function testActiveFromCache()
    {
        $cacheActivator = new CacheActivator(
            $arrayActivator = $this->createMock(FeatureActivatorInterface::class),
            $cachePool = $this->createMock(CacheItemPoolInterface::class)
        );

        $arrayActivator
            ->method('getName')
            ->willReturn('array');

        $arrayActivator
            ->expects(static::never())
            ->method('isActive');

        $context = new Context();
        $hash = CacheActivator::CACHE_KEY . '#' . 'array' . '#' . md5('feature_foo' . '-' . $context->serialize());

        $cachePool
            ->expects(static::once())
            ->method('getItem')
            ->with($hash)
            ->willReturn($cacheItem = $this->createMock(CacheItemInterface::class));

        $cacheItem
            ->expects(static::once())
            ->method('isHit')
            ->willReturn(true);

        $cacheItem
            ->expects(static::once())
            ->method('get')
            ->willReturn(true);

        static::assertTrue($cacheActivator->isActive('feature_foo', $context));
        static::assertTrue($cacheActivator->isActive('feature_foo', $context));
        static::assertTrue($cacheActivator->isActive('feature_foo', $context));
    }
    /**
     * Test feature result is written to cache
     *
     * @return void
     */
    public function testActiveWriteCache()
    {
        $cacheActivator = new CacheActivator(
            $arrayActivator = $this->createMock(FeatureActivatorInterface::class),
            $cachePool = new ArrayAdapter()
        );

        $arrayActivator
            ->method('getName')
            ->willReturn('array');

        $arrayActivator
            ->expects(static::once())
            ->method('isActive')
            ->with('feature_foo', $context = new Context())
            ->willReturn(true);

        static::assertTrue($cacheActivator->isActive('feature_foo', $context));
        static::assertTrue($cacheActivator->isActive('feature_foo', $context));
        static::assertTrue($cacheActivator->isActive('feature_foo', $context));
    }
}
