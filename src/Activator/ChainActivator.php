<?php

namespace Flagception\Activator;

use Flagception\Model\Context;
use Flagception\Model\Result;

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
        $activatorName = null;
        foreach ($this->bag as $activator) {
            if ($activator->isActive($name, $context) === true) {
                $activatorName = $activator->getName();

                break;
            }
        }

        return new Result($name, $activatorName !== null, $context, $activatorName);
    }
}
