<?php

namespace FeatureTox\Manager;

use FeatureTox\Activator\FeatureActivatorInterface;
use FeatureTox\Decorator\ContextDecoratorInterface;
use FeatureTox\Model\Context;

class FeatureManager implements FeatureManagerInterface
{
    private FeatureActivatorInterface $activator;

    private ?ContextDecoratorInterface $decorator;

    public function __construct(FeatureActivatorInterface $activator, ContextDecoratorInterface $decorator = null)
    {
        $this->activator = $activator;
        $this->decorator = $decorator;
    }

    public function isActive($name, Context $context = null): bool
    {
        if ($context === null) {
            $context = new Context();
        }

        $context->replace('_feature', $name);

        if ($this->decorator !== null) {
            $context = $this->decorator->decorate($context);
        }

        return $this->activator->isActive($name, $context);
    }
}
