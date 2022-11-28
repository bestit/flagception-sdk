<?php

namespace Flagception\Constraint\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class MatchProvider
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Constraint\Provider
 */
class MatchProvider implements ExpressionFunctionProviderInterface
{
    /**
     * {@inheritdoc}
     */
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
