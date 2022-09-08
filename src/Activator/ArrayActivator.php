<?php

namespace FeatureTox\Activator;

use FeatureTox\Model\Context;

class ArrayActivator implements FeatureActivatorInterface
{
    private array $features;

    public function __construct(array $features = [])
    {
        $this->features = $features;
    }

    public function getName(): string
    {
        return 'array';
    }

    public function isActive($name, Context $context): bool
    {
        if (array_key_exists($name, $this->features)) {
            return filter_var($this->features[$name], FILTER_VALIDATE_BOOLEAN);
        }

        return in_array($name, $this->features, true);
    }
}
