<?php

namespace Flagception\Constraint;

use Flagception\Exception\ConstraintSyntaxException;
use Flagception\Model\Context;

/**
 * Interface ConstraintResolverInterface
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Constraint
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
