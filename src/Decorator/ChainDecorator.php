<?php

namespace FeatureTox\Decorator;

use FeatureTox\Model\Context;

class ChainDecorator implements ContextDecoratorInterface
{
    /**
     * Ordered array of decorators
     *
     * @var ContextDecoratorInterface[]
     */
    private array $bag = [];

    public function add(ContextDecoratorInterface $decorator): void
    {
        $this->bag[] = $decorator;
    }

    /**
     * @return ContextDecoratorInterface[]
     */
    public function getDecorators(): array
    {
        return $this->bag;
    }

    public function getName(): string
    {
        return 'chain';
    }

    public function decorate(Context $context): Context
    {
        foreach ($this->bag as $decorator) {
            $context = $decorator->decorate($context);
        }

        return $context;
    }
}
