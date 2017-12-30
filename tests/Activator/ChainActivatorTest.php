<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\ChainActivator;
use Flagception\Activator\FeatureActivatorInterface;
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
}
