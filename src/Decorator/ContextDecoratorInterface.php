<?php

namespace FeatureTox\Decorator;

use FeatureTox\Model\Context;

/**
 * Interface ContextDecoratorInterface
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Decorator
 */
interface ContextDecoratorInterface
{
    /**
     * Get decorator name
     *
     * @return string
     */
    public function getName();

    /**
     * Decorate the context object with global settings
     *
     * @param Context $context
     *
     * @return Context
     */
    public function decorate(Context $context);
}
