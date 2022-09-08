<?php

namespace FeatureTox\Manager;

use FeatureTox\Model\Context;

/**
 * Interface FeatureManagerInterface
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package FeatureTox\Manager
 */
interface FeatureManagerInterface
{
    /**
     * Check if feature is active
     *
     * @param string $name
     * @param Context|null $context
     *
     * @return bool
     */
    public function isActive($name, Context $context = null);
}
