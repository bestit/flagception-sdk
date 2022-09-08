<?php

namespace FeatureTox\Activator;

use FeatureTox\Model\Context;

interface FeatureActivatorInterface
{
    public function getName(): string;

    /**
     * Check if the given feature name is active
     * Optional the context object can contain further options to check
     *
     * @param string $name
     * @param Context $context
     *
     * @return bool
     */
    public function isActive(string $name, Context $context): bool;
}
