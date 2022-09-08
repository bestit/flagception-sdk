<?php

namespace FeatureTox\Decorator;

use FeatureTox\Model\Context;

class ArrayDecorator implements ContextDecoratorInterface
{
    private array $defaultValues;

    public function __construct(array $defaultValues = [])
    {
        $this->defaultValues = $defaultValues;
    }

    public function getName(): string
    {
        return 'array';
    }

    public function decorate(Context $context): Context
    {
        foreach ($this->defaultValues as $key => $value) {
            $context->add($key, $value);
        }

        return $context;
    }
}
