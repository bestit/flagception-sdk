<?php

namespace FeatureTox\Constraint;

use FeatureTox\Exception\ConstraintSyntaxException;
use FeatureTox\Model\Context;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

class ConstraintResolver implements ConstraintResolverInterface
{
    private ExpressionLanguage $expressionLanguage;

    public function __construct(ExpressionLanguage $expressionLanguage)
    {
        $this->expressionLanguage = $expressionLanguage;
    }

    public function resolve($constraint, Context $context): bool
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
