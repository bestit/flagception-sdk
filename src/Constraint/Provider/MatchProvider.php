<?php

namespace FeatureTox\Constraint\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class MatchProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return array(
            new ExpressionFunction(
                'match',
                function ($pattern, $value) {
                    return sprintf('preg_match(%1$s, %2$s) === 1', $pattern, $value);
                },
                function ($arguments, $pattern, $value) {
                    return preg_match($pattern, $value) === 1;
                }
            ),
        );
    }
}
