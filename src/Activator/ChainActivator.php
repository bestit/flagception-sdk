<?php

namespace FeatureTox\Activator;

use FeatureTox\Model\Context;

class ChainActivator implements FeatureActivatorInterface
{
    /**
     * At least one activator must return true to activating the feature (default)
     */
    public const STRATEGY_FIRST_MATCH = 1;

    /**
     * All activators must return true to activating the feature
     */
    public const STRATEGY_ALL_MATCH = 2;

    /**
     * The reserved name for strategy override via context
     */
    public const CONTEXT_STRATEGY_NAME = 'chain_strategy';

    /**
     * Ordered array of feature activators
     *
     * @var FeatureActivatorInterface[]
     */
    private array $bag = [];

    /**
     * The used strategy
     */
    private int $strategy;

    public function __construct(int $strategy = self::STRATEGY_FIRST_MATCH)
    {
        $this->strategy = $strategy;
    }

    public function add(FeatureActivatorInterface $activator): void
    {
        $this->bag[] = $activator;
    }

    /**
     * Get activators bag
     *
     * @return FeatureActivatorInterface[]
     */
    public function getActivators(): array
    {
        return $this->bag;
    }

    public function getName(): string
    {
        return 'chain';
    }

    public function isActive($name, Context $context): bool
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
