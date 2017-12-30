<?php

namespace Flagception\Tests\Factory;

use Flagception\Constraint\Provider\DateProvider;
use Flagception\Factory\ExpressionLanguageFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class ExpressionLanguageFactoryTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\Factory
 */
class ExpressionLanguageFactoryTest extends TestCase
{
    /**
     * Test create with providers
     *
     * @return void
     */
    public function testCreate()
    {
        $expressionLanguage = new ExpressionLanguage();
        $expressionLanguage->registerProvider(new DateProvider());

        $factory = new ExpressionLanguageFactory();
        $factory->addProvider(new DateProvider());

        static::assertEquals($expressionLanguage, $factory->create());
    }
}
