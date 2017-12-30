<?php

namespace Flagception\Activator;

use Flagception\Model\Context;

/**
 * Interface FeatureActivatorInterface
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
interface FeatureActivatorInterface
{
    /**
     * Get unique activator name
     *
     * @return string
     */
    public function getName();

    /**
     * Check if the given feature name is active
     * Optional the context object can contain further options to check
     *
     * @param string $name
     * @param Context $context
     *
     * @return bool
     */
    public function isActive($name, Context $context);
}
