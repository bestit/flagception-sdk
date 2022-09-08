<?php

namespace FeatureTox\Tests\Activator;

use FeatureTox\Activator\ArrayActivator;
use FeatureTox\Activator\FeatureActivatorInterface;
use FeatureTox\Decorator\ArrayDecorator;
use FeatureTox\Decorator\ContextDecoratorInterface;
use FeatureTox\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrayDecoratorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Activator
 */
class ArrayDecoratorTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(ContextDecoratorInterface::class, new ArrayDecorator());
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $decorator = new ArrayDecorator();
        static::assertEquals('array', $decorator->getName());
    }

    /**
     * Test decoration with empty array
     *
     * @return void
     */
    public function testDecorateWithEmptyArray()
    {
        $decorator = new ArrayDecorator();
        $decorator->decorate($context = new Context());

        static::assertEquals([], $context->all());
    }

    /**
     * Test decoration
     *
     * @return void
     */
    public function testDecorate()
    {
        $decorator = new ArrayDecorator([
            'foo' => 'bar',
            'bazz' => 99,
        ]);

        $decorator->decorate($context = new Context());

        static::assertEquals([
            'foo' => 'bar',
            'bazz' => 99,
        ], $context->all());
    }
}
