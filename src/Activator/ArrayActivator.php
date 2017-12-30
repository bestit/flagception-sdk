<?php

namespace Flagception\Activator;

use Flagception\Model\Context;

/**
 * Class ArrayActivator
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
class ArrayActivator implements FeatureActivatorInterface
{
    /**
     * Active features
     *
     * @var array
     */
    private $activeFeatures;

    /**
     * ArrayActivator constructor.
     *
     * @param array $activeFeatures
     */
    public function __construct(array $activeFeatures = [])
    {
        $this->activeFeatures = $activeFeatures;
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
    public function isActive($name, Context $context)
    {
        return in_array($name, $this->activeFeatures, true);
    }
}
