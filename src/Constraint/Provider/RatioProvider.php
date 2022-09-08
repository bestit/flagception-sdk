<?php

namespace FeatureTox\Constraint\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class RatioProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
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
