<?php

namespace Flagception\Decorator;

use Flagception\Model\Context;

/**
 * Class ChainDecorator
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Decorator
 */
class ChainDecorator implements ContextDecoratorInterface
{
    /**
     * Ordered array of decorators
     *
     * @var ContextDecoratorInterface[]
     */
    private $bag = [];

    /**
     * Add context decorator
     *
     * @param ContextDecoratorInterface $decorator
     *
     * @return void
     */
    public function add(ContextDecoratorInterface $decorator)
    {
        $this->bag[] = $decorator;
    }

    /**
     * Get decorators bag
     *
     * @return ContextDecoratorInterface[]
     */
    public function getDecorators()
    {
        return $this->bag;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'chain';
    }

    /**
     * {@inheritdoc}
     */
    public function decorate(Context $context)
    {
        foreach ($this->bag as $decorator) {
            $context = $decorator->decorate($context);
        }

        return $context;
    }
}
