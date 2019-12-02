<?php

namespace Flagception\Activator;

use Flagception\Model\Context;

/**
 * Class EnvironmentActivator
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Activator
 */
class EnvironmentActivator implements FeatureActivatorInterface
{
    /**
     * Variable array mapping
     *
     * @var array
     */
    private $variables;

    /**
     * Force environment request
     *
     * @var boolean
     */
    private $forceRequest;

    /**
     * EnvironmentActivator constructor.
     *
     * @param array $variables
     * @param bool $forceRequest
     */
    public function __construct(array $variables = [], $forceRequest = false)
    {
        $this->variables = $variables;
        $this->forceRequest = $forceRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'environment';
    }

    /**
     * {@inheritdoc}
     */
    public function isActive($name, Context $context)
    {
        if ($this->forceRequest === false && !array_key_exists($name, $this->variables)) {
            return false;
        }

        if ($this->forceRequest === true && !array_key_exists($name, $this->variables)) {
            return $this->getEnv($name);
        }

        return $this->getEnv($this->variables[$name]);
    }

    /**
     * Get enviroment value by $_ENV or getenv()
     *
     * @param $name
     *
     * @return string|null
     */
    private function getEnv($name)
    {
        return filter_var(
            array_key_exists($name, $_ENV) ? $_ENV[$name] : getenv($name),
            FILTER_VALIDATE_BOOLEAN
        );
    }
}
