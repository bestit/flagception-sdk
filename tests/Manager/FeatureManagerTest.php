<?php

namespace Flagception\Tests\Listener;

use Flagception\Activator\ArrayActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Decorator\ArrayDecorator;
use Flagception\Manager\FeatureManager;
use Flagception\Manager\FeatureManagerInterface;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Class FeatureManagerTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Listener
 */
class FeatureManagerTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        $manager = new FeatureManager(
            new ArrayActivator(),
            new ArrayDecorator()
        );

        static::assertInstanceOf(FeatureManagerInterface::class, $manager);
    }

    /**
     * Test feature not active
     *
     * @return void
     */
    public function testFeatureNotActive()
    {
        $manager = new FeatureManager(
            new ArrayActivator(),
            new ArrayDecorator()
        );

        static::assertFalse($manager->isActive('feature_foo'));
    }

    /**
     * Test feature is active without context
     *
     * @return void
     */
    public function testFeatureActiveWithoutContext()
    {
        $manager = new FeatureManager(
            new ArrayActivator(['feature_foo']),
            new ArrayDecorator()
        );

        static::assertTrue($manager->isActive('feature_foo'));
    }

    /**
     * Test feature is active with context
     *
     * @return void
     */
    public function testFeatureActiveWithContext()
    {
        $manager = new FeatureManager(
            $activator = $this->createMock(FeatureActivatorInterface::class),
            new ArrayDecorator()
        );

        $context = new Context();
        $context->add('user_id', 23);
        $context->add('role', 'ROLE_ADMIN');

        $activator
            ->expects(static::once())
            ->method('isActive')
            ->with('feature_foo', $context)
            ->willReturn(true);

        static::assertTrue($manager->isActive('feature_foo', $context));
    }

    /**
     * Test decorator is optional
     *
     * @return void
     */
    public function testFeatureWithoutDecorator()
    {
        $manager = new FeatureManager(
            new ArrayActivator(['feature_foo'])
        );

        static::assertTrue($manager->isActive('feature_foo'));
    }

    /**
     * Test feature is active from cache
     *
     * @return void
     */
    public function testFeatureActiveFromCache()
    {
        $manager = new FeatureManager(
            new ArrayActivator([]),
            new ArrayDecorator()
        );

        $manager->setCache($adapter = new ArrayAdapter(), 3600);
        $context = new Context();
        $hash = FeatureManager::CACHE_KEY . '-' . md5('feature_foo' . '-' . $context->serialize());

        $cacheItem = $adapter->getItem($hash);
        $cacheItem->set(true);
        $adapter->save($cacheItem);

        static::assertTrue($manager->isActive('feature_foo'));
        static::assertTrue($manager->isActive('feature_foo'));
        static::assertTrue($manager->isActive('feature_foo'));
    }

    /**
     * Test feature result is written to cache
     *
     * @return void
     */
    public function testFeatureActiveWriteCache()
    {
        $adapter = new ArrayAdapter();
        $activator = $this->createMock(FeatureActivatorInterface::class);

        $activator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $manager = new FeatureManager(
             $activator,
            new ArrayDecorator()
        );
        $manager->setCache($adapter, 3600);

        // From activator
        static::assertTrue($manager->isActive('feature_foo'));

        // Further results from cache
        $manager2 = new FeatureManager(
            $activator,
            new ArrayDecorator()
        );
        $manager2->setCache($adapter, 3600);
        static::assertTrue($manager2->isActive('feature_foo'));
        static::assertTrue($manager2->isActive('feature_foo'));
    }

    /**
     * Test feature is active from memory
     *
     * @return void
     */
    public function testFeatureActiveFromMemory()
    {
        $manager = new FeatureManager(
            $activator = $this->createMock(FeatureActivatorInterface::class)
        );

        $activator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        static::assertTrue($manager->isActive('feature_foo'));

        // Now all results must come from memory
        static::assertTrue($manager->isActive('feature_foo'));
        static::assertTrue($manager->isActive('feature_foo'));
    }
}
