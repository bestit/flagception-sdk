<?php

namespace FeatureTox\Tests\Constraint\Provider;

use FeatureTox\Constraint\Provider\DateProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class DateProviderTest extends TestCase
{
    /**
     * Test provider implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(ExpressionFunctionProviderInterface::class, new DateProvider());
    }

    /**
     * Test provider and `date` function
     *
     * @return void
     */
    public function testProvider()
    {
        $expressionLanguage = new ExpressionLanguage();
        $expressionLanguage->registerProvider(new DateProvider());

        static::assertEquals(date('Y'), $expressionLanguage->evaluate('date("Y")'));
        static::assertEquals('date("Y", time())', $expressionLanguage->compile('date("Y")'));
    }
}
