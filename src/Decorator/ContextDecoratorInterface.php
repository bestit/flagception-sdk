<?php

namespace FeatureTox\Decorator;

use FeatureTox\Model\Context;

/**
 * Interface ContextDecoratorInterface
 *
 * @author Michel Chowanski <michel.chowanski@office-partner.de>
 * @package FeatureTox\Decorator
 */
interface ContextDecoratorInterface
{
    public function getName(): string;

    /**
     * Decorate the context object with global settings
     */
    public function decorate(Context $context): Context;
}
