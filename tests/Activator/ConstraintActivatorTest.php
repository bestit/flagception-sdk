<?php

namespace FeatureTox\Tests\Activator;

use FeatureTox\Activator\ConstraintActivator;
use FeatureTox\Activator\FeatureActivatorInterface;
use FeatureTox\Constraint\ConstraintResolver;
use FeatureTox\Model\Context;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class ConstraintActivatorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package FeatureTox\Tests\Activator
 */
class ConstraintActivatorTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(FeatureActivatorInterface::class, new ConstraintActivator(
            new ConstraintResolver(new ExpressionLanguage())
        ));
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $activator = new ConstraintActivator(
            new ConstraintResolver(new ExpressionLanguage())
        );

        static::assertEquals('constraint', $activator->getName());
    }


    /**
     * Test is active by constraint array
     *
     * @return void
     */
    public function testIsActiveByConstraintArray()
    {
        $activator = new ConstraintActivator(
            new ConstraintResolver(new ExpressionLanguage()),
            ['feature_1' => '"ROLE_ADMIN" in user_role']
        );

        static::assertFalse($activator->isActive('feature_99', new Context()));

        $context = new Context();
        $context->add('user_role', []);
        static::assertFalse($activator->isActive('feature_1', $context));

        $context->replace('user_role', ['ROLE_USER', 'ROLE_PUBLISHER', 'ROLE_ADMIN']);
        static::assertTrue($activator->isActive('feature_1', $context));
    }

    /**
     * Test is active by constraint int
     *
     * @return void
     */
    public function testIsActiveByConstraintInt()
    {
        $activator = new ConstraintActivator(
            new ConstraintResolver(new ExpressionLanguage()),
            ['feature_1' => 'user_id === 12']
        );

        static::assertFalse($activator->isActive('feature_99', new Context()));

        $context = new Context();
        $context->add('user_id', 10);
        static::assertFalse($activator->isActive('feature_1', $context));

        $context->replace('user_id', 12);
        static::assertTrue($activator->isActive('feature_1', $context));
    }
}
