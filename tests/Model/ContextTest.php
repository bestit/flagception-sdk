<?php

namespace Flagception\Tests\Model;

use Flagception\Exception\AlreadyDefinedException;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class ContextTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Model
 */
class ContextTest extends TestCase
{
    /**
     * Test storage is empty
     *
     * @return void
     */
    public function testEmptyStorage()
    {
        $context = new Context();
        static::assertEquals([], $context->all());
    }

    /**
     * Test add context value
     *
     * @return void
     */
    public function testAdd()
    {
        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');

        static::assertEquals(['foo' => 'bar', 'role' => 'ROLE_ADMIN'], $context->all());
    }

    /**
     * Test add context value throw exception if already defined
     *
     * @return void
     */
    public function testAddThrowException()
    {
        $this->expectException(AlreadyDefinedException::class);

        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');
        $context->add('foo', 'bar');
    }

    /**
     * Test replace context value
     *
     * @return void
     */
    public function testReplace()
    {
        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');
        $context->replace('foo', 'best-it');

        static::assertEquals(['foo' => 'best-it', 'role' => 'ROLE_ADMIN'], $context->all());
    }

    /**
     * Test get context value return null
     *
     * @return void
     */
    public function testGetReturnNull()
    {
        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');

        static::assertEquals(null, $context->get('bar'));
    }

    /**
     * Test get context value return default value
     *
     * @return void
     */
    public function testGetReturnDefaultValue()
    {
        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');

        static::assertEquals('best-it', $context->get('bar', 'best-it'));
    }

    /**
     * Test get context value return value
     *
     * @return void
     */
    public function testGetReturnValue()
    {
        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');

        static::assertEquals('ROLE_ADMIN', $context->get('role', 'best-it'));
    }

    /**
     * Test all return complete storage
     *
     * @return void
     */
    public function testAll()
    {
        $context = new Context();
        $context->add('foo', 'bar');
        $context->add('role', 'ROLE_ADMIN');

        static::assertEquals(['foo' => 'bar', 'role' => 'ROLE_ADMIN'], $context->all());
    }

    /**
     * Test has context value
     *
     * @return void
     */
    public function testHas()
    {
        $context = new Context();
        static::assertFalse($context->has('foo'));

        $context->add('foo', 'bar');
        static::assertTrue($context->has('foo'));
    }

    /**
     * Test serialize and unserialize object
     *
     * @return void
     */
    public function testSerializable()
    {
        $context = new Context();
        $context->add('test_1', 'foobar');
        $context->add('test_2', 'bazzfoo');
        $context->add('test_3', ['key' => 'value']);

        /** @var Context $context2 */
        $context2 = unserialize(serialize($context));        static::assertEquals('foobar', $context2->get('test_1'));
        static::assertEquals('bazzfoo', $context2->get('test_2'));
        static::assertEquals(['key' => 'value'], $context2->get('test_3'));
    }
}
