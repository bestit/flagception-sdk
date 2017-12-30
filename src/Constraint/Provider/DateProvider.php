<?php

namespace Flagception\Constraint\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class DateProvider
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Constraint\Provider
 */
class DateProvider implements ExpressionFunctionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
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
