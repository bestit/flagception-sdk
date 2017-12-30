<?php

namespace Flagception\Activator;

use Flagception\Constraint\ConstraintResolverInterface;
use Flagception\Model\Context;

/**
 * Class ConstraintActivator
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
class ConstraintActivator implements FeatureActivatorInterface
{
    /**
     * The constraint resolver
     *
     * @var ConstraintResolverInterface
     */
    private $resolver;

    /**
     * Features names and constraints
     *
     * @var array
     */
    private $features;

    /**
     * ConstraintActivator constructor.
     *
     * @param ConstraintResolverInterface $resolver
     * @param array $features
     */
    public function __construct(ConstraintResolverInterface $resolver, array $features = [])
    {
        $this->resolver = $resolver;
        $this->features = $features;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'constraint';
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($name, Context $context)
    {
        if (!array_key_exists($name, $this->features)) {
            return false;
        }

        return $this->resolver->resolve($this->features[$name], $context);
    }
}
