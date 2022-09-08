<?php

namespace FeatureTox\Tests\Constraint;

use FeatureTox\Constraint\ConstraintResolver;
use FeatureTox\Constraint\ConstraintResolverInterface;
use FeatureTox\Exception\ConstraintSyntaxException;
use FeatureTox\Model\Context;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ConstraintResolverTest extends TestCase
{
    /**
     * Test resolver implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(ConstraintResolverInterface::class, new ConstraintResolver(new ExpressionLanguage()));
    }

    /**
     * Test resolve to true
     *
     * @return void
     */
    public function testResolveTrue()
    {
        $resolver = new ConstraintResolver(new ExpressionLanguage());

        $context = new Context();
        $context->add('first', 5);
        $context->add('second', 5);

        static::assertTrue($resolver->resolve('context.get("second")+first == 10',$context));
        static::assertTrue($resolver->resolve('context.get("second")+first == context.get("third", 10)',$context));
    }

    /**
     * Test resolve to false
     *
     * @return void
     */
    public function testResolveFalse()
    {
        $resolver = new ConstraintResolver(new ExpressionLanguage());

        $context = new Context();
        $context->add('first', 5);
        $context->add('second', 5);

        static::assertFalse($resolver->resolve('context.get("second")+first == 20',$context));
    }

    /**
     * Test resolve throw exception
     *
     * @return void
     */
    public function testResolveFail()
    {
        $this->expectException(ConstraintSyntaxException::class);

        $resolver = new ConstraintResolver(new ExpressionLanguage());

        $context = new Context();
        $context->add('first', 5);
        $context->add('second', 5);

        $resolver->resolve('context.get("second")+first =*= 20',$context);
    }
}
