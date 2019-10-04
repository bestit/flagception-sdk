<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\ArrayActivator;
use Flagception\Activator\ChainActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Exception\AlreadyDefinedException;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class ChainActivatorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Tests\Activator
 */
class ChainActivatorTest extends TestCase
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
        $activator = new ChainActivator();
        static::assertEquals('chain', $activator->getName());
    }

    /**
     * Test with empty array
     *
     * @return void
     */
    public function testWithEmptyArray()
    {
       $activator = new ChainActivator();

       static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test that chain will be breake if one activator returns true
     *
     * @return void
     */
    public function testBreakCheck()
    {
        $activator = new ChainActivator();
        $activator->add($firstActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($secondActivator = $this->createMock(FeatureActivatorInterface::class));

        $firstActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $secondActivator
            ->expects(static::never())
            ->method('isActive');

        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test chain activators and order
     *
     * @return void
     */
    public function testChainOrder()
    {
        $activator = new ChainActivator();
        $activator->add($firstActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($secondActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($thirdActivator = $this->createMock(FeatureActivatorInterface::class));

        $firstActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(false);

        $secondActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(false);

        $thirdActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test add and get activators
     *
     * @return void
     */
    public function testAddAndGet()
    {
        $decorator = new ChainActivator();
        $decorator->add($fakeActivator1 = new ArrayActivator());
        $decorator->add($fakeActivator2 = new ArrayActivator([]));

        // Should be the same sorting
        static::assertSame($fakeActivator1, $decorator->getActivators()[0]);
        static::assertSame($fakeActivator2, $decorator->getActivators()[1]);
    }

    /**
     * Test match all strategy
     *
     * @return void
     */
    public function testMatchAllStrategy()
    {
        $activator = new ChainActivator(ChainActivator::STRATEGY_ALL_MATCH);
        $activator->add($firstActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($secondActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($thirdActivator = $this->createMock(FeatureActivatorInterface::class));

        $firstActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $secondActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $thirdActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        static::assertTrue($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test match all strategy break as soon as possible
     *
     * @return void
     */
    public function testMatchAllStrategyBreakChain()
    {
        $activator = new ChainActivator(ChainActivator::STRATEGY_ALL_MATCH);
        $activator->add($firstActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($secondActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($thirdActivator = $this->createMock(FeatureActivatorInterface::class));

        $firstActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $secondActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(false);

        $thirdActivator
            ->expects(static::never())
            ->method('isActive');

        static::assertFalse($activator->isActive('feature_abc', new Context()));
    }

    /**
     * Test match all strategy
     *
     * @return void
     *
     * @throws AlreadyDefinedException
     */
    public function testContextOverrideStrategy()
    {
        $activator = new ChainActivator(ChainActivator::STRATEGY_FIRST_MATCH);
        $activator->add($firstActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($secondActivator = $this->createMock(FeatureActivatorInterface::class));
        $activator->add($thirdActivator = $this->createMock(FeatureActivatorInterface::class));

        $firstActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $secondActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $thirdActivator
            ->expects(static::once())
            ->method('isActive')
            ->willReturn(true);

        $context = new Context();
        $context->add('chain_strategy', ChainActivator::STRATEGY_ALL_MATCH);
        static::assertTrue($activator->isActive('feature_abc', $context));
    }

    /**
     * Test public constants
     *
     * @return void
     */
    public function testConstants()
    {
        static::assertEquals(1, ChainActivator::STRATEGY_FIRST_MATCH);
        static::assertEquals(2, ChainActivator::STRATEGY_ALL_MATCH);
        static::assertEquals('chain_strategy', ChainActivator::CONTEXT_STRATEGY_NAME);
    }
}
