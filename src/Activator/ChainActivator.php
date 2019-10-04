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
     * At least one activator must return true to activating the feature (default)
     */
    const STRATEGY_FIRST_MATCH = 1;

    /**
     * All activators must return true to activating the feature
     */
    const STRATEGY_ALL_MATCH = 2;

    /**
     * The reserved name for strategy override via context
     */
    const CONTEXT_STRATEGY_NAME = 'chain_strategy';

    /**
     * Ordered array of feature activators
     *
     * @var FeatureActivatorInterface[]
     */
    private $bag = [];

    /**
     * The used strategy
     *
     * @var int
     */
    private $strategy;

    /**
     * ChainActivator constructor.
     *
     * @param int $strategy
     */
    public function __construct($strategy = self::STRATEGY_FIRST_MATCH)
    {
        $this->strategy = $strategy;
    }

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
        $strategy = $context->get(self::CONTEXT_STRATEGY_NAME, $this->strategy);

        if ($strategy === self::STRATEGY_ALL_MATCH) {
            $result = true;
            foreach ($this->bag as $activator) {
                if ($activator->isActive($name, $context) === false) {
                    $result = false;
                    break;
                }
            }
        } else {
            $result = false;
            foreach ($this->bag as $activator) {
                if ($activator->isActive($name, $context) === true) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }
}
