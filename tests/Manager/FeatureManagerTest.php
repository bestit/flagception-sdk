<?php

namespace FeatureTox\Tests\Listener;

use FeatureTox\Activator\ArrayActivator;
use FeatureTox\Activator\FeatureActivatorInterface;
use FeatureTox\Decorator\ArrayDecorator;
use FeatureTox\Decorator\ContextDecoratorInterface;
use FeatureTox\Manager\FeatureManager;
use FeatureTox\Manager\FeatureManagerInterface;
use FeatureTox\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class FeatureManagerTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Listener
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
     * Test feature exists in context
     *
     * @return void
     */
    public function testFeatureExistsInContext()
    {
        $manager = new FeatureManager(
            new ArrayActivator(['feature_foo']),
            new AssertFeatureExistsContextDecorator('feature_foo')
        );

        static::assertTrue($manager->isActive('feature_foo'));
    }
}

class AssertFeatureExistsContextDecorator implements ContextDecoratorInterface
{
    private $feature;

    public function __construct($feature)
    {
        $this->feature = $feature;
    }

    public function getName() {
        return 'foobar';
    }

    public function decorate(Context $context)
    {
        TestCase::assertTrue($context->has('_feature'));
        TestCase::assertSame($this->feature, $context->get('_feature'));
        return $context;
    }
}
