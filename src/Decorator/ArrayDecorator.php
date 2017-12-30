<?php

namespace Flagception\Decorator;

use Flagception\Model\Context;

/**
 * Class ArrayDecorator
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package Flagception\Decorator
 */
class ArrayDecorator implements ContextDecoratorInterface
{
    /**
     * Active features
     *
     * @var array
     */
    private $defaultValues;

    /**
     * ArrayDecorator constructor.
     *
     * @param array $defaultValues
     */
    public function __construct(array $defaultValues = [])
    {
        $this->defaultValues = $defaultValues;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'array';
    }

    /**
     * {@inheritdoc}
     */
    public function decorate(Context $context)
    {
        foreach ($this->defaultValues as $key => $value) {
            $context->add($key, $value);
        }

        return $context;
    }
}
