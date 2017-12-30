<?php

namespace Flagception\Tests\Constraint\Provider;

use Flagception\Constraint\Provider\MatchProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class MatchProviderTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Constraint\Provider
 */
class MatchProviderTest extends TestCase
{
    /**
     * Test provider implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(ExpressionFunctionProviderInterface::class, new MatchProvider());
    }

    /**
     * Test provider and `match` function
     *
     * @return void
     */
    public function testProvider()
    {
        $expressionLanguage = new ExpressionLanguage();
        $expressionLanguage->registerProvider(new MatchProvider());

        static::assertEquals(true, $expressionLanguage->evaluate('match("/foo/i", "FOO")'));
        static::assertEquals(true, $expressionLanguage->evaluate('match("/127.\\\d+.\\\d+.\\\d+/", "127.0.0.1")'));
        static::assertEquals(false, $expressionLanguage->evaluate('match("/127.\\\d+.\\\d+.\\\d+/", "127.A.B.1")'));

        static::assertEquals('preg_match("/foo/i", "FOO") === 1', $expressionLanguage->compile('match("/foo/i", "FOO")'));
    }
}
