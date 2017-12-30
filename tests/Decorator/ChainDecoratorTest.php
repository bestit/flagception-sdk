<?php

namespace Flagception\Tests\Activator;

use Flagception\Decorator\ArrayDecorator;
use Flagception\Decorator\ChainDecorator;
use Flagception\Decorator\ContextDecoratorInterface;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class ChainDecoratorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Tests\Activator
 */
class ChainDecoratorTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(ContextDecoratorInterface::class, new ChainDecorator());
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $decorator = new ChainDecorator();
        static::assertEquals('chain', $decorator->getName());
    }

    /**
     * Test decoration with empty array
     *
     * @return void
     */
    public function testDecorateWithEmptyArray()
    {
        $decorator = new ChainDecorator();
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
        $decorator = new ChainDecorator();
        $decorator->add(new ArrayDecorator([
            'foo' => 'bar',
            'bazz' => 99
        ]));

        $decorator->add(new ArrayDecorator([
            'bar' => 'foo',
            'flop' => 12
        ]));

        $decorator->decorate($context = new Context());

        static::assertEquals([
            'foo' => 'bar',
            'bazz' => 99,
            'bar' => 'foo',
            'flop' => 12
        ], $context->all());
    }
}
