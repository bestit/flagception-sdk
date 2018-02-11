<?php

namespace Flagception\Model;

/**
 * Result of feature request
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Model
 */
class Result
{
    /**
     * The feature name
     *
     * @var string
     */
    private $feature;

    /**
     * Is feature active
     *
     * @var bool
     */
    private $isActive;

    /**
     * The context
     *
     * @var Context
     */
    private $context;

    /**
     * The activator name
     *
     * @var string
     */
    private $activatorName;

    /**
     * Stack constructor.
     *
     * @param string $feature
     * @param bool $isActive
     * @param Context $context
     * @param null|string $activatorName
     */
    public function __construct($feature, $isActive, Context $context, $activatorName = null)
    {
        $this->feature = $feature;
        $this->isActive = $isActive;
        $this->context = $context;
        $this->activatorName = $activatorName;
    }

    /**
     * Get feature
     *
     * @return string
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * Get context
     *
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Get activator name
     *
     * @return string|null
     */
    public function getActivatorName()
    {
        return $this->activatorName;
    }
}
