<?php

namespace FeatureTox\Activator;

use FeatureTox\Constraint\ConstraintResolverInterface;
use FeatureTox\Model\Context;

class ConstraintActivator implements FeatureActivatorInterface
{
    private ConstraintResolverInterface $resolver;

    /**
     * Features names and constraints
     */
    private array $features;

    public function __construct(ConstraintResolverInterface $resolver, array $features = [])
    {
        $this->resolver = $resolver;
        $this->features = $features;
    }

    public function getName(): string
    {
        return 'constraint';
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($name, Context $context): bool
    {
        if (!array_key_exists($name, $this->features)) {
            return false;
        }

        return $this->resolver->resolve($this->features[$name], $context);
    }
}
