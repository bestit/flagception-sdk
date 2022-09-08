<?php

namespace FeatureTox\Constraint;

use FeatureTox\Exception\ConstraintSyntaxException;
use FeatureTox\Model\Context;

/**
 * Interface ConstraintResolverInterface
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Constraint
 */
interface ConstraintResolverInterface
{
    /**
     * Resolve a constraint expression
     *
     * @param $constraint
     * @param Context $context
     *
     * @return bool
     * @throws ConstraintSyntaxException
     */
    public function resolve($constraint, Context $context);
}
