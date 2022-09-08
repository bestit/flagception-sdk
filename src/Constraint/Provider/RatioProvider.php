<?php

namespace FeatureTox\Constraint\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class RatioProvider
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Constraint\Provider
 */
class RatioProvider implements ExpressionFunctionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new ExpressionFunction(
                'ratio',
                function ($ratio) {
                    return sprintf('return mt_rand(0, 99) < %1$s * 100', $ratio);
                },
                function ($arguments, $ratio) {
                    return mt_rand(0, 99) < $ratio * 100;
                }
            ),
        );
    }
}
