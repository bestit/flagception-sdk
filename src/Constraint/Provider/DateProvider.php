<?php

namespace FeatureTox\Constraint\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class DateProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return array(
            new ExpressionFunction(
                'date',
                function ($value) {
                    return sprintf('date(%1$s, time())', $value);
                },
                function ($arguments, $str) {
                    return date($str, time());
                }
            ),
        );
    }
}
