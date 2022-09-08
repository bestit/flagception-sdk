<?php

namespace FeatureTox\Constraint;

use FeatureTox\Exception\ConstraintSyntaxException;
use FeatureTox\Model\Context;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

/**
 * Class ConstraintResolver
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Constraint
 */
class ConstraintResolver implements ConstraintResolverInterface
{
    /**
     * The expression language parser
     *
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * ConstraintResolver constructor.
     *
     * @param ExpressionLanguage $expressionLanguage
     */
    public function __construct(ExpressionLanguage $expressionLanguage)
    {
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($constraint, Context $context)
    {
        try {
            return $this->expressionLanguage->evaluate($constraint, array_merge(
                $context->all(),
                ['context' => $context]
            ));
        } catch (SyntaxError $exception) {
            throw new ConstraintSyntaxException('Feature constraint expression is invalid', 0, $exception);
        }
    }
}
