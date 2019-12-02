<?php

namespace Flagception\Tests\Activator;

use Flagception\Activator\EnvironmentActivator;
use Flagception\Activator\FeatureActivatorInterface;
use Flagception\Model\Context;
use PHPUnit\Framework\TestCase;

/**
 * Class EnvironmentActivatorTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Tests\Activator
 */
class EnvironmentActivatorTest extends TestCase
{
    /**
     * Test implement interface
     *
     * @return void
     */
    public function testImplementInterface()
    {
        static::assertInstanceOf(FeatureActivatorInterface::class, new EnvironmentActivator());
    }

    /**
     * Test name
     *
     * @return void
     */
    public function testName()
    {
        $activator = new EnvironmentActivator();
        static::assertEquals('environment', $activator->getName());
    }

    /**
     * Test unmapped variable without force returns false
     *
     * @return void
     */
    public function testUnmappedVariableWithoutForce()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator();
        static::assertFalse($activator->isActive('FOOBAR_TEST_FLAGCEPTION', new Context()));
        static::assertFalse($activator->isActive('BAZZ_TEST_FLAGCEPTION', new Context()));
    }

    /**
     * Test unmapped variable with force returns true
     *
     * @return void
     */
    public function testUnmappedVariableWithForce()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator([], true);
        static::assertTrue($activator->isActive('FOOBAR_TEST_FLAGCEPTION', new Context()));
        static::assertTrue($activator->isActive('BAZZ_TEST_FLAGCEPTION', new Context()));
    }

    /**
     * Test unknown variable with force returns false
     *
     * @return void
     */
    public function testUnknownVariableWithForce()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator([], true);
        static::assertFalse($activator->isActive('FOOBAR_FEATURE', new Context()));
    }

    /**
     * Test mapped variable without force returns true
     *
     * @return void
     */
    public function testMappedVariableWithoutForce()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator([
            'feature_test' => 'FOOBAR_TEST_FLAGCEPTION',
            'feature_bazz' => 'BAZZ_TEST_FLAGCEPTION'
        ]);
        static::assertTrue($activator->isActive('feature_test', new Context()));
        static::assertTrue($activator->isActive('feature_bazz', new Context()));
    }

    /**
     * Test mapped variable with force returns true
     *
     * @return void
     */
    public function testMappedVariableWithForce()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator([
            'feature_test' => 'FOOBAR_TEST_FLAGCEPTION',
            'feature_bazz' => 'BAZZ_TEST_FLAGCEPTION'
        ], true);
        static::assertTrue($activator->isActive('feature_test', new Context()));
        static::assertTrue($activator->isActive('feature_bazz', new Context()));
    }

    /**
     * Test wrong mapped variable
     *
     * @return void
     */
    public function testWrongMappedVariable()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator([
            'feature_test' => 'FOOBAR_TEST_FLAGCEPTION',
            'feature_bazz' => 'BAZZ_TEST_FLAGCEPTION'
        ]);
        static::assertFalse($activator->isActive('bazz_foo', new Context()));
    }

    /**
     * Test wrong environment mapped variable
     *
     * @return void
     */
    public function testWrongEnvironmentMappedVariable()
    {
        putenv('FOOBAR_TEST_FLAGCEPTION=true');
        $_ENV['BAZZ_TEST_FLAGCEPTION'] = true;

        $activator = new EnvironmentActivator([
            'feature_test' => 'FOOBAR_FAIL',
            'feature_bazz' => 'BAZZ_FAIL'
        ]);
        static::assertFalse($activator->isActive('feature_test', new Context()));
        static::assertFalse($activator->isActive('feature_bazz', new Context()));
    }
}
