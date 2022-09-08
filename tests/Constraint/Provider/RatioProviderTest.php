<?php

namespace FeatureTox\Tests\Constraint\Provider;

use FeatureTox\Constraint\Provider\RatioProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class RatioProviderTest extends TestCase
{
    /**
     * Test provider implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(ExpressionFunctionProviderInterface::class, new RatioProvider());
    }

    /**
     * Test provider and `ratio` function
     *
     * @return void
     */
    public function testProvider()
    {
        $expressionLanguage = new ExpressionLanguage();
        $expressionLanguage->registerProvider(new RatioProvider());

        $hits = 0;
        for ($i = 0; $i < 50; $i++) {
            static::assertEquals(false, $expressionLanguage->evaluate('ratio(0)'));
            static::assertEquals(true, $expressionLanguage->evaluate('ratio(1)'));

            if ($expressionLanguage->evaluate('ratio(0.3)') === true) {
                $hits++;
            }
        }

        # No really precise test / maybe fail at runtime.
        static::assertGreaterThanOrEqual(5, $hits);
        static::assertLessThanOrEqual(50, $hits);

        static::assertEquals('return mt_rand(0, 99) < 0.3 * 100', $expressionLanguage->compile('ratio(0.3)'));
    }
}
