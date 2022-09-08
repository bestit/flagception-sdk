<?php

namespace FeatureTox\Factory;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class ExpressionLanguageFactory
{
    /**
     * @var ExpressionFunctionProviderInterface[]
     */
    private array $providers;

    public function addProvider(ExpressionFunctionProviderInterface $provider): void
    {
        $this->providers[] = $provider;
    }

    public function create(): ExpressionLanguage
    {
        $language = new ExpressionLanguage();

        foreach ($this->providers as $provider) {
            $language->registerProvider($provider);
        }

        return $language;
    }
}
