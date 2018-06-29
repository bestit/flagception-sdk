<?php

namespace Flagception\Activator;

use Flagception\Model\Context;

/**
 * Class ChainActivator
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
class ChainActivator implements FeatureActivatorInterface
{
    /**
     * Ordered array of feature activators
     *
     * @var FeatureActivatorInterface[]
     */
    private $bag = [];

    /**
     * Add activator
     *
     * @param FeatureActivatorInterface $activator
     *
     * @return void
     */
    public function add(FeatureActivatorInterface $activator)
    {
        $this->bag[] = $activator;
    }

    /**
     * Get activators bag
     *
     * @return FeatureActivatorInterface[]
     */
    public function getActivators()
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
    public function isActive($name, Context $context)
    {
        foreach ($this->bag as $activator) {
            if ($activator->isActive($name, $context) === true) {
                return true;
            }
        }

        return false;
    }
}
