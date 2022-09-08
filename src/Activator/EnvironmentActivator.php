<?php

namespace FeatureTox\Activator;

use FeatureTox\Model\Context;

class EnvironmentActivator implements FeatureActivatorInterface
{
    private array $variables;

    /**
     * Force environment request
     *
     * @var boolean
     */
    private bool $forceRequest;

    public function __construct(array $variables = [], bool $forceRequest = false)
    {
        $this->variables = $variables;
        $this->forceRequest = $forceRequest;
    }

    public function getName(): string
    {
        return 'environment';
    }

    public function isActive($name, Context $context): bool
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
     * Get environment value by $_ENV or getenv()
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
